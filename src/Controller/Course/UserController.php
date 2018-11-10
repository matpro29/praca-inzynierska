<?php

namespace App\Controller\Course;

use App\Entity\Course;
use App\Entity\User;
use App\Repository\NoticeRepository;
use App\Repository\UserRepository;
use App\Service\Parameter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/course/user")
 */
class UserController extends Controller
{
    private $security;
    private $parameter;

    public function __construct(NoticeRepository $noticeRepository, Security $security)
    {
        $this->security = $security;
        $this->parameter = new Parameter($noticeRepository, $security);
    }

    /**
     * @Route("/info/{courseId}/{userId}", name="course_user_info")
     * @ParamConverter("course", options={"id": "courseId"})
     * @ParamConverter("userInfo", options={"id": "userId"})
     */
    public function info(Course $course, User $userInfo): Response
    {
        $params = [
            'course' => $course,
            'userInfo' => $userInfo
        ];

        $params = $this->parameter->getParams($this, $params);

        return $this->render('course/user/info.html.twig', $params);
    }

    /**
     * @Route("/{id}", name="course_user", methods="GET|POST")
     */
    public function index(Course $course, UserRepository $userRepository): Response
    {
        $users = $userRepository->findAllByCourseId($course->getId());

        $params = [
            'course' => $course,
            'users' => $users
        ];

        $params = $this->parameter->getParams($this, $params);

        return $this->render('course/user/index.html.twig', $params);
    }
}
