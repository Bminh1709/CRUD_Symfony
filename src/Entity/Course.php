<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 */
class Course
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
    private $name;

    // /**
    //  * @ORM\Column(type="string", length=255)
    //  */
    // private $teacher;

    /**
     * @ORM\Column(type="date")
     */
    private $startday;

    /**
     * @ORM\Column(type="date")
     */
    private $endday;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $des;

    /**
     * @ORM\Column(type="float")
     */
    private $price;


     /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="courses", fetch="EAGER")
     */
    private $teacher;

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }
    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;
        return $this;
    }
    // public function __construct()
    // {
    //     $this->teachers = new ArrayCollection();
    // }
    // /**
    //  * @return Collection|Teacher[]
    //  */
    // public function getTeachers(): Collection
    // {
    //     return $this->teachers;
    // }

    // public function addTeacher(Teacher $teacher): self
    // {
    //     if (!$this->teachers->contains($teacher)) {
    //         $this->teachers[] = $teacher;
    //         $teacher->addPart($this);
    //     }

    //     return $this;
    // }

    // public function removeTeacher(Teacher $teacher): self
    // {
    //     if ($this->teachera->removeElement($teacher)) {
    //         $teacher->removePart($this);
    //     }

    //     return $this;
    // }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    // public function getTeacher(): ?string
    // {
    //     return $this->teacher;
    // }

    // public function setTeacher(string $teacher): self
    // {
    //     $this->teacher = $teacher;

    //     return $this;
    // }

    public function getStartday(): ?\DateTimeInterface
    {
        return $this->startday;
    }

    public function setStartday(\DateTimeInterface $startday): self
    {
        $this->startday = $startday;

        return $this;
    }

    public function getEndday(): ?\DateTimeInterface
    {
        return $this->endday;
    }

    public function setEndday(\DateTimeInterface $endday): self
    {
        $this->endday = $endday;

        return $this;
    }

    public function getDes(): ?string
    {
        return $this->des;
    }

    public function setDes(string $des): self
    {
        $this->des = $des;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
