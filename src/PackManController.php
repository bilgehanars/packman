<?php

namespace Bilgehanars\PackMan;

use Illuminate\Support\Arr;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Composer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput as Output;
use Symfony\Component\Console\Output\OutputInterface;
use Flarum\Group\Permission;
use Flarum\Foundation;
use Flarum\Foundation\Paths;
use Flarum\User\AssertPermissionTrait;


class PackManController implements RequestHandlerInterface {
        protected $view;
        public $packadi;
        public $SiteAnaSayfa;
        public $komut;
        public $outputs;
        public $output;
        public $input;
            
        public function handle(Request $request): Response
        {

                $packadi = Arr::get($request->getParsedBody(), 'packadi');
                $komut = Arr::get($request->getParsedBody(), 'komut');
                $SiteAnaSayfa = app(Paths::class)->base;
                
                $request->getAttribute('actor')->assertAdmin();    
                if (str_starts_with($packadi, "flarum/") && $komut == 'remove') { // eğer packadi flarum/ ile başlıyor ve komut remove ise
                        $outputs = 'INVALID OPERATION'; // output değerine Invalid operation yaz
                } 
                else {
                ini_set('memory_limit', '2G');
                set_time_limit(300);
                    
                putenv('COMPOSER_HOME=' . $SiteAnaSayfa . '/vendor/bin/composer');
    
                $output = new Output;
                if ($komut=='prohibits'){
                        $input = new ArrayInput([
                                'command' => $komut, 
                                'package' => 'flarum/core', 
                                '--working-dir' => $SiteAnaSayfa,
                                'version' => '*'
                        ]);
                }
                else {
                $input = new ArrayInput([
                        'command' => $komut, 
                        'packages' => [ $packadi ], 
                        '--working-dir' => $SiteAnaSayfa
                ]);
                }
                $application = new Application();
                $application->setAutoExit(false);
                $application->run($input, $output);
                $outputs = ' ';
                $outputs .= $output->fetch();
        }
                $response = new JsonResponse($outputs);
                $response = $response->withStatus(200);
                return $response;
    
        }
 
        

}   