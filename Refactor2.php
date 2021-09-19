<?php

class Course {

    private $isAdvanced = false;
    private $name = '';

    public function __construct(string $name, bool $isAdvanced) {
        $this->isAdvanced = $isAdvanced;
        $this->name = $name;
    }

    public function isAdvanced(): bool {
        return $this->isAdvanced;
    }
}

class Person {
    private $courses; // SplObjectStorage

    public function getCourses() {
        return $this->courses;
    }
    public function setCourses(SplObjectStorage $arg) {
        $this->courses = $arg;
    }
}

// Client code
$luis = new Person();

$s = new SplObjectStorage();
$s->attach(new Course("React", true));
$s->attach(new Course("Codeigniter", true));
$luis->setCourses($s);
assert(2 === $luis->getCourses()->count());

$refact = new Course("Vue", true);
$luis->getCourses()->attach($refact);
$luis->getCourses()->attach(new Course("Angular", false));
assert(4 === $luis->getCourses()->count());

$luis->getCourses()->detach($refact);
assert(3 === $luis->getCourses()->count());

$count = 0;
foreach ($luis->getCourses() as $course) {
    if ($course->isAdvanced()) {
        $count++;
    }
}

print("Advanced courses: " . $count);