<?php

namespace ReservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use ReservationBundle\Entity\Reservation;
use ReservationBundle\Entity\Salle;

class DefaultController extends Controller
{
    /**
     * @Route("/home", name="reservationbundle_index")
     * @Template()
     */
    public function indexAction()
    {
		/*$em = $this->getDoctrine()->getManager();*/
		
		$salle1 = new Salle();
		$salle1->setNom('Salle1');
		$salle2 = new Salle();
		$salle2->setNom('Salle2');
		
		$resa = new Reservation();
		$resa->setNom('Reservation1');
		$resa->setSalle($salle1);
		
		/*$em->persist($salle1);
		$em->persist($salle2);
		$em->persist($resa);
		
		$em->flush();*/
		
        return array(
				'ma_reservation' => $resa,
		);
    }
    
    /**
     * @Route("/salles", name="reservationbundle_salles")
     * @Template()
     */
    public function sallesAction()
    {		
		$em = $this->getDoctrine()->getManager();
		$repoSalles = $em->getRepository('ReservationBundle:Salle');
		
		$salles = $repoSalles->findall();

        return array(
			'les_salles' => $salles,
		);
    }
    
    /**
     * @Route("/salles/{id}", name="reservationbundle_voir", requirements={"id"="\d+"})
     * @Template()
     */
    public function voirAction($id)
    {		
		$em = $this->getDoctrine()->getManager();
		$repoSalles = $em->getRepository('ReservationBundle:Salle');
		
		$salle = $repoSalles->findOneById($id);
		dump($salle);

		if(!$salle) {
			throw $this->createNotFoundException('La salle avec l\'id '.$id.' n\'existe pas...');
		}
		
        return array(
			'la_salle' => $salle,
		);
    }
    
    /**
     * @Route("/reservations", name="reservationbundle_reservations")
     * @Template()
     */
    public function reservationsAction()
    {		
        $em = $this->getDoctrine()->getManager();
		$repoResas = $em->getRepository('ReservationBundle:Reservation');
		
		$resas = $repoResas->findall();

        return array(
			'les_resas' => $resas,
		);
    }
    
    /**
     * @Route("/reserver", name="reservationbundle_reserver")
     * @Template()
     */
    public function reserverAction()
    {		
		$em = $this->getDoctrine()->getManager();		
		
        return array();
    }
}
