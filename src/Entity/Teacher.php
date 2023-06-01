<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $englishname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vietnamname;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $phone;

    /**
     * @ORM\Column(type="date")
     */
    private $datestartwork;



     /**
     * @ORM\OneToMany(targetEntity=Course::class, mappedBy="teacher")
     */
    private $courses;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }
    /**
     * @return Collection|Course[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setTeacher($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->removeElement($course)){
            if ($course->getTeacher() === $this)
            {
                $course->setTeacher(null);
            }
        }

        return $this;
    }




    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnglishname(): ?string
    {
        return $this->englishname;
    }

    public function setEnglishname(string $englishname): self
    {
        $this->englishname = $englishname;

        return $this;
    }

    public function getVietnamname(): ?string
    {
        return $this->vietnamname;
    }

    public function setVietnamname(string $vietnamname): self
    {
        $this->vietnamname = $vietnamname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDatestartwork(): ?\DateTimeInterface
    {
        return $this->datestartwork;
    }

    public function setDatestartwork(\DateTimeInterface $datestartwork): self
    {
        $this->datestartwork = $datestartwork;

        return $this;
    }
}
