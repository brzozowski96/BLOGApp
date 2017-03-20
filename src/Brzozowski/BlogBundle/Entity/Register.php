<?php
namespace Brzozowski\BlogBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="registrations")
 */
class Register
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     message = "Wpisz swoje imię i nazwisko."
     * )
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]+ [a-zA-Z]+$/",
     *     message="Wpisz tutaj swoje prawidłowe imię i nazwisko"
     * )
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank()
     *
     * @Assert\Email(
     *     message="Wpisz tutaj prawidłowy adres E-mail"
     * )
     * @Assert\Length(
     *     max=255
     * )
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     *
     * @Assert\Choice(
     *     choices = { "m", "f"},
     *     message = "Wybierz płeć."
     * )
     */
    protected $sex;

    /**
     * @ORM\Column(type="date", nullable=true)
     *
     * @Assert\Date(
     *     message = "Wybierz datę."
     * )
     */
    protected $birthdate;

    /**
     * @ORM\Column(type="string", length=2)
     *
     * @Assert\NotBlank(
     *     message="Wpisz tutaj kraj swojego zamieszkania"
     * )
     */
    protected $country;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(
     *     message="Wybierz kurs"
     * )
     */
    protected $course;

    /**
     * @ORM\Column(type="array")
     *
     * @Assert\NotBlank(
     *     message="Wybierz inwestycję"
     * )
     * @Assert\Count(
     *      min = 2,
     *      minMessage = "Musisz wybrać przynajmniej dwie inwestycje"
     * )
     */
    protected $invest;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $comments;

    /**
     * @Assert\NotBlank(
     *     message="Wybierz plik PDF z potwierdzeniem przelewu"
     * )
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Wybierz prawidłowy plik PDF"
     * )
     */
    protected $payment_file;

    /**
     * @Assert\NotBlank(
     *     message="Musisz zaakceptować regulamin"
     * )
     */
    protected $rules;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getCourse()
    {
        return $this->course;
    }

    public function setCourse($course)
    {
        $this->course = $course;
    }

    public function getInvest()
    {
        return $this->invest;
    }

    public function setInvest($invest)
    {
        $this->invest = $invest;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    public function getPaymentFile()
    {
        return $this->payment_file;
    }

    public function setPaymentFile($payment_file)
    {
        $this->payment_file = $payment_file;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function save($savePath)
    {
        $paramsNames = array('name', 'email', 'sex', 'birthdate', 'country', 'course', 'invest', 'comments', 'payment_file');
        $formData = array();
        foreach ($paramsNames as $name)
        {
            $formData[$name] = $this->{$name};
        }

        $randVal = rand(1000, 9999);
        $dataFileName = sprintf('data_%d.txt', $randVal);

        //file_put_contents($savePath, $dataFileName, print_r($formData, TRUE));
        file_put_contents($savePath.$dataFileName, print_r($formData, TRUE));

        $file = $this->getPaymentFile();
        if(NULL !== $file)
        {
            $newName = sprintf('file_%d.%s', $randVal, $file->guessExtension());
            $file->move($savePath, $newName);
        }
    }
}
?>