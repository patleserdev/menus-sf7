<?php

namespace App\MessageHandler;

use App\Message\MenusPDFMessage;
use DateTime;
use Symfony\Component\Process\Process;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Knp\Snappy\Pdf;

#[AsMessageHandler]
final class MenusMessageHandler{

    public function __construct(
        #[Autowire('%kernel.project_dir%/public/pdfs')]
        private readonly string $path,
        private readonly UrlGeneratorInterface $urlGenerator
        
        )
    {
        
    }
    public function __invoke(MenusPDFMessage $message) :void
    {
        // je génére grâce à gotenberg
        // docker run --rm -p 3000:3000 gotenberg/gotenberg:8
       /* 
        $process= new Process([
            'curl',
            '--request',
            'POST',
            'http://localhost:3000/forms/chromium/convert/url',
            '--form',
            'url=' . $this->urlGenerator->generate('app_menus_list',['id' => $message->id] , UrlGeneratorInterface::ABSOLUTE_URL),
            '-o',
            $this->path . '/' .$message->id . '.pdf'
*/

/*
            $process= new Process([
            'curl',
            '--request',
            'POST',
            'http://localhost:3000/forms/chromium/convert/url',
            '--form',
            'url='. $this->urlGenerator->generate('app_menus_list',['id' => $message->id] , UrlGeneratorInterface::ABSOLUTE_URL),
            '--form',
            'marginTop=0',
            '--form',
            'marginBottom=0',
            '--form',
            'marginLeft=0',
            '--form',
            'marginRight=0',
            '--form',
            'emulatedMediaType=screen',
            '-o' ,
            $this->path . '/' .$message->id . '.pdf'
                    ]  
        );
      
        $process->run();

        if(!$process->isSuccessful())
        {
            throw new ProcessFailedException($process);
        }
        */

        /* vérifie si fichier existe , s'il existe, je fais une v2 , à terme je recopierai **/

        if (is_file($this->path . '/' .$message->id . '.pdf'))
        {
            $date=new DateTime();
            $content=$message->id.'-'.$date->format('Y-m-d-s');
        }

        else
        {
            $content=$message->id;
        }

        $knpSnappyPdf = new Pdf('wkhtmltopdf');

        //$knpSnappyPdf->generate($this->urlGenerator->generate('app_menus_list',['id' => $message->id] , UrlGeneratorInterface::ABSOLUTE_URL),$this->path . '/' .$message->id . '.pdf' );

        $knpSnappyPdf->generate($message->route,$this->path . '/' . $content . '.pdf' );
   
        /*
        $client = new Client('http://localhost:3000', new \Http\Adapter\Guzzle6\Client());
        $request = new URLRequest($this->urlGenerator->generate('app_menus_list',['id' => $message->id] , UrlGeneratorInterface::ABSOLUTE_URL));
        $request->setMargins(Request::NO_MARGINS);
        $dest = $this->path . '/' .$message->id . '.pdf';
        $client->store($request, $dest);

        */

        //$url=$this->urlGenerator->generate('app_home',['id' => $message->id] , UrlGeneratorInterface::ABSOLUTE_URL);
        //file_put_contents($this->path .'/'. $message->id .'.pdf',"echo $this->urlGenerator->generate('app_home',['id' => $message->id] , UrlGeneratorInterface::ABSOLUTE_URL);");

        //file_put_contents($this->path .'/'. $message->id .'.pdf',"$url");
        
        
    }
}