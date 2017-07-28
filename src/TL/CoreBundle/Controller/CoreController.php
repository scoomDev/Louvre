<?php

namespace TL\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $date = $_POST['_submit'];
            $nbrPerson = $_POST['nbr_person'];
            return $this->redirectToRoute('tl_core_informations', [
                'date' => $date,
                'nbrPerson' => $nbrPerson
            ]);
        }

        return $this->render('TLCoreBundle:Core:index.html.twig');
    }

    public function informationsAction($date, $nbrPerson)
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('TLCoreBundle:Core:informations.html.twig', [
            'date' => $date,
            'nbrPerson' => $nbrPerson
        ]);
    }
}
