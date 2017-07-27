<?php

namespace PhotoDownload\Commands;

use PhotoDownload\Exceptions\AlbumsNotFoundException;
use PhotoDownload\Exceptions\DirectoryCreationException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use PhotoDownload\Models\User;
use PhotoDownload\Creators\PhotoCreator;
use PhotoDownload\Creators\AlbumCreator;
use PhotoDownload\Savers\MysqlSaver;

/**
 * Class PhotoDownloadCommand
 * @package PhotoDownload\Commands
 */
class PhotoDownloadCommand extends Command
{

    /**
     * Command configuration
     */
    protected function configure()
    {
        $this->setName('app:download-photo')
            ->setDescription('Vk albums download')
            ->addArgument('id', InputArgument::REQUIRED, 'Vk user id whose albums would be downloaded')
            ->addOption('dir', null, InputOption::VALUE_REQUIRED, 'Directory to download', '');
    }

    /**
     * Command execution
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Getting user id from input
        $id = (int)trim($input->getArgument('id'));
        //Getting directory from input
        $dir = trim($input->getOption('dir'));
        try{
            //Creating new user
            $user = new User($id);
            try {
                //User info retrieving
                $user->getUserInfoFromApi();
                //Directory path check
                if($dir == null or file_exists($dir)) {
                    $output->writeln("Searching " .
                        $user->getName() . " " . $user->getLastName() . " albums\n");
                }else{
                    throw new InvalidOptionException("Directory does not exist");
                }
            } catch (InvalidArgumentException $err) {
                $output->writeln($err->getMessage()."\n");
            } catch (InvalidOptionException $err){
                $output->writeln($err->getMessage()."\n");
            }
            $albCreator = new AlbumCreator($user, $dir);
            try {
                //Creating array of Album objects
                $albums = $albCreator->getAlbums($albCreator->getAlbumsInfoFromApi());
            } catch (AlbumsNotFoundException $err) {
                $output->writeln($err->getMessage()."\n");
            }
            try {
                //Mysql user saving
                $user->save(new MysqlSaver());
            }catch(\PDOException $err){
                $output->writeln("User with passed id already exists in database");
            }
            //Albums iteration
            foreach ($albums as $alb) {
                $phtCreator = new PhotoCreator($alb);
                //Creating array of Photo Objects
                $photos = $phtCreator->getPhotos($phtCreator->getPhotosInfoFromApi());
                //Album photos set
                $alb->setPhotos($photos);
                try {
                    //Album save
                    $alb->save(new MysqlSaver(), $dir);
                    if (isset($photos)) {
                        //Album photos iteration
                        foreach ($photos as $photo) {
                            //Photo save
                            $photo->save(new MysqlSaver());
                        }
                    } else {
                        $output->writeln("Album without photos\n");
                    }
                } catch (DirectoryCreationException $err) {
                    $output->writeln($err->getMessage() . "\n");
                } catch (\PDOException $err){
                    $output->writeln("Album ". $alb->getName()." already exists in database". "\n");
                }
            }
        }catch(Exception $e){
            $output->writeln($e->getMessage()."\n");
        }

    }

}
