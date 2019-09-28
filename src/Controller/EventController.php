<?php

namespace App\Controller;

use App\Entity\Events;
use App\Form\EventType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{

    /**
     * @Route("/calendar", name="event_calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('event/calendar.html.twig');
    }

    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $em): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $em->getRepository(Events::class)->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="event_new", options={"expose"=true}, methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Events();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="event_show", requirements={"id"="\d+"},methods={"GET"})
     */
    public function show(Events $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit/{fromCalendar}", name="event_edit", requirements={"id"="\d+", "fromCalendat"="1|0"}, methods={"GET","POST"})
     */
    public function edit(Request $request, Events $event, bool $fromCalendar, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            if ($fromCalendar) {

                return new Response('<script type="text/javascript">window.parent.location.reload(true);</script>');
            }

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'fromCalendar' => $fromCalendar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="event_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete(Request $request, Events $image, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $em->remove($image);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * @param Request $request
     * @param EntityManager $em
     * @return JsonResponse
     *
     * @Route("/load_calendar", name="front_load_calendar", options={"expose"=true}, methods={"GET"})
     */
    public function load(Request $request, EntityManagerInterface $em)
    {
        $start = \DateTime::createFromFormat('Y-m-d', $request->get('start'))->setTime(0, 0, 0);
        $end = \DateTime::createFromFormat('Y-m-d', $request->get('end'))->setTime(0, 0, 0);
        $eventResults = $em->getRepository(Events::class)->getEvents($start, $end);
        $events = [];
        foreach ($eventResults as $event) {
            $events[] = array(
                'id' => $event->getId(),
                "start" => $event->getStartDate()->format('Y-m-d H:i:s'),
                "end" => $event->getEndDate()->format('Y-m-d H:i:s'),
                "title" => $event->getTitle(),
                "color" => "#95b338",
                'type' => 'meeting',
                "textColor" => '#fff',
                'edit_path' =>  $this->generateUrl('event_edit', ['id' => $event->getId(),'fromCalendar' => 1]),
                'popoverTitle' => 'RDV téléphonique'
            );
        }

        return new JsonResponse([
            'events' => $events
        ]);
    }
}
