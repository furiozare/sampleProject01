<?php

namespace AppBundle\Controller\Front\Api;

use AppBundle\Entity\Artikel;
use AppBundle\Entity\ArtikelEmail;
use AppBundle\Entity\EmailSubscribe;
use AppBundle\Manager\ArtikelEmailManager;
use AppBundle\Manager\ArtikelManager;
use AppBundle\Manager\EmailSubscribeManager;
use JMS\DiExtraBundle\Annotation\Inject;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ArtikelApiController
 *
 * @package AppBundle\Controller\Front\Api
 *
 * @Route(path="/api/artikel", name="app_api_artikel")
 */
class ArtikelApiController extends Controller
{
    /**
     * @var Serializer
     * @Inject("serializer")
     */
    private $serializer;

    /**
     * @var ArtikelManager
     * @Inject("manager.artikel")
     */
    private $artikelManager;

    /**
     * @var EmailSubscribeManager
     * @Inject("manager.emailSubscribe")
     */
    private $emailSubscribeManager;

    /**
     * @var ArtikelEmailManager
     * @Inject("manager.artikelEmail")
     */
    private $artikelEmailManager;

    /**
     * @Route("/blast", name="app_api_artikel_blast", methods={"GET"})
     */
    public function blastAction(Request $request)
    {
        $response = [
            'result' => 'error',
            'errors' => []
        ];

        $break = false;
        $seed  = 10;

        $artikels = $this->artikelManager->findAllMarkForBlast();

        if (count($artikels) > 0) {
            foreach ($artikels as $artikel) {
                /** @var Artikel $artikel */
                if ($seed < 0) {
                    $break = true;
                    break;
                }

                $emailSubscribes = $this->emailSubscribeManager->findAllAktifNotYetBlastedByArtikelId($artikel->getId());

                if (count($emailSubscribes)) {
                    foreach ($emailSubscribes as $emailSubscribe) {
                        /** @var EmailSubscribe $emailSubscribe */
                        if ($seed < 0) {
                            $break = true;
                            break;
                        }

                        $artikelEmail = new ArtikelEmail();
                        $artikelEmail->setEmailSubscribe($emailSubscribe);
                        $artikelEmail->setArtikel($artikel);
                        $this->artikelEmailManager->save($artikelEmail);

                        $message = \Swift_Message::newInstance()
                            ->setSubject($artikel->getJudul())
                            ->setFrom('noreply@bahanayamaha.com')
                            ->setReplyTo("support@bahanayamaha.com")
                            ->setTo($emailSubscribe->getEmail())
                            ->setBody(
                                $this->renderView(
                                    'AppBundle:Front/Email:newArticleEmail.html.twig',
                                    [
                                        'artikel'        => $artikel,
                                        'emailSubscribe' => $emailSubscribe
                                    ]
                                ),
                                'text/html'
                            );

                        $message->getHeaders()->addIdHeader("Message-ID", time() . "system@bahanayamaha.com");
                        $message->getHeaders()->addTextHeader('MIME-Version', '1.0');
                        $message->getHeaders()->addTextHeader('X-Mailer', 'PHP v' . phpversion());
                        $message->getHeaders()->addParameterizedHeader('Content-type', 'text/html',
                            ['charset' => 'utf-8']);

                        $this->get('mailer')->send($message);

                        $seed -= 1;
                    }

                    if (!$break) {
                        $artikel->setMarkForBlast(false);
                        $artikel->setBlastedAt(new \DateTime());
                        $this->artikelManager->save($artikel);
                    }
                } else {
                    $artikel->setMarkForBlast(false);
                    $artikel->setBlastedAt(new \DateTime());
                    $this->artikelManager->save($artikel);
                }
            }
        }

        $response['result'] = 'success';

        return new JsonResponse($response);
    }
}
