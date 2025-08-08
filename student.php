<?php
/**
 * Student class to store student information. Must be built using the 
 * StudentBuilder class.
 */
class Student {
    private int $id;
    private string $fullname;
    private string $email;
    private string $dob;
    private string $course;
    private int $yearlevel;
    private string $contact;
    private string $gender;
    private string $picture;
    private string $picture_data;

    /**
     * @param StudentBuilder $builder
     */
    public function __construct($builder){
        $this->id = $builder->getId();
        $this->fullname = $builder->getFullname();
        $this->email = $builder->getEmail();
        $this->dob = $builder->getDOB();
        $this->course = $builder->getCourse();
        $this->yearlevel = $builder->getYearlevel();
        $this->contact = $builder->getContact();
        $this->gender = $builder->getGender();
        $this->picture = $builder->getPicture();
        $this->picture_data = $builder->getPicture();
    }

    function getPictureData() : string{
        return $this->picture_data;
    }

    function getPicture() : string{
        return $this->picture;
    }

    function getGender() : string{
        return $this->gender;
    }

    function getContact() : string {
        return $this->contact;
    }

    function getYearlevel() : int {
        return $this->yearlevel;
    }

    function getCourse() : string {
        return $this->course;
    }

    function getDOB() : string {
        return $this->dob;
    }

    function getEmail() : string {
        return $this->email;
    }

    function getFullname() : string {
        return $this->fullname;
    }

    function getId() : int {
        return $this->id;
    }

}

/**
 * Used to build an instance of Student. This follows the Builder Design Pattern
 * to make instantiations more readable.
 */
class StudentBuilder {
    private int $id = -1;
    private string $fullname = "";
    private string $email = "";
    private string $dob = "";
    private string $course = "";
    private int $yearlevel = 1;
    private string $contact = "";
    private string $gender = "";
    private string $picture = "";
    private string $picture_data = "";

    function getPictureData() : string {
        return $this->picture_data;
    }

    function getPicture() : string {
        return $this->picture;
    }

    function getGender() : string{
        return $this->gender;
    }

    function getContact() : string {
        return $this->contact;
    }

    function getYearlevel() : int {
        return $this->yearlevel;
    }

    function getCourse() : string {
        return $this->course;
    }

    function getDOB() : string {
        return $this->dob;
    }

    function getEmail() : string {
        return $this->email;
    }

    function getFullname() : string {
        return $this->fullname;
    }

    function getId() : int {
        return $this->id;
    }

    /**
     * @param int $id
     */
    function setId($id): StudentBuilder {
        $this->id=$id;
        return $this;
    }

    /**
     * @param string $fullname
     */
    function setFullname($fullname): StudentBuilder {
        $this->fullname=$fullname;
        return $this;
    }

    /**
     * @param string $email
     */
    function setEmail($email): StudentBuilder {
        $this->email=$email;
        return $this;
    }

    /**
     * @param string $dob
     */
    function setDOB($dob): StudentBuilder {
        $this->dob=$dob;
        return $this;
    }

    /**
     * @param string $course
     */
    function setCourse($course): StudentBuilder {
        $this->course=$course;
        return $this;
    }

    /**
     * @param string $yearlevel
     */
    function setYearLevel($yearlevel): StudentBuilder {
        $this->yearlevel=$yearlevel;
        return $this;
    }

    /**
     * @param string $contact
     */
    function setContact($contact): StudentBuilder {
        $this->contact=$contact;
        return $this;
    }

    /**
     * @param string $gender
     */
    function setGender($gender): StudentBuilder {
        $this->gender=$gender;
        return $this;
    }

    /**
     * @param string $picture
     */
    function setPicture($picture): StudentBuilder {
        $this->picture=$picture;
        return $this;
    }

    /**
     * @param string $picture_data
     */
    function setPictureData($picture_data): StudentBuilder {
        $this->picture_data=$picture_data;
        return $this;
    }

    function build(): Student {
        return new Student($this);
    }

}
?>
