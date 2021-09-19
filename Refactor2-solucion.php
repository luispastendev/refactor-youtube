<?php

class Course {

    private $isAdvanced = false;
    private $name = '';

    public function __construct(string $name, bool $isAdvanced) 
    {
        $this->isAdvanced = $isAdvanced;
        $this->name = $name;
    }

    public function isAdvanced(): bool 
    {
        return $this->isAdvanced;
    }
}

class Person {

    private $courses; // SplObjectStorage

    public function __construct()
    {
        $this->courses = new SplObjectStorage();
    }

    public function getCourses(): SplObjectStorage 
    {
        return clone $this->courses;
    }

    public function intializeCourses(SplObjectStorage $arg) 
    {
        $this->courses->addAll($arg);
    }

    public function addCourse(Course $course)
    {
        $this->courses->attach($course);
    }

    public function numberOfCourses(): int
    {
        return $this->courses->count();
    }

    public function removeCourse(Course $course)
    {
        $this->courses->detach($course);
    }

    public function numberOfAdvancedCourses(): int
    {
        $count = 0;
        foreach ($this->getCourses() as $course) {
            if ($course->isAdvanced()) {
                $count++;
            }
        }
        return $count;
    }
}

// Client code
$luis = new Person();

$luis->addCourse(new Course("React", true));
$luis->addCourse(new Course("Codeigniter", true));
assert(2 === $luis->numberOfCourses());

$refact = new Course("Vue", true);
$luis->addCourse($refact);
$luis->addCourse(new Course("Angular", false));
assert(4 === $luis->numberOfCourses());

$luis->removeCourse($refact);
assert(3 === $luis->numberOfCourses());

$count = $luis->numberOfAdvancedCourses();
print("Advanced courses: " . $count);