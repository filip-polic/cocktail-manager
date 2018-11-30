<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Cocktail
 *
 * @ORM\Table(name="cocktails")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CocktailRepository")
 * @UniqueEntity("name", message="Cocktail with the same name already exists.")
 */
class Cocktail
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=640)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="preparation", type="string", length=1024)
     */
    private $preparation;

    /**
     * @var string
     *
     * @ORM\Column(name="difficulty", type="string", length=32)
     */
    private $difficulty;

    /**
     * @var ArrayCollection
     * @Serializer\MaxDepth(2)
     * @Serializer\Groups("cocktail_show")
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ingredient", inversedBy="cocktails")
     */
    private $ingredients;

    /**
     * @var User
     * @Serializer\Exclude()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="cocktails", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $user;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Cocktail
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Cocktail
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set preparation.
     *
     * @param string $preparation
     *
     * @return Cocktail
     */
    public function setPreparation($preparation)
    {
        $this->preparation = $preparation;

        return $this;
    }

    /**
     * Get preparation.
     *
     * @return string
     */
    public function getPreparation()
    {
        return $this->preparation;
    }

    /**
     * Set difficulty.
     *
     * @param string $difficulty
     *
     * @return Cocktail
     */
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get difficulty.
     *
     * @return string
     */
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * @return ArrayCollection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Add ingredient.
     *
     * @param Ingredient $ingredient
     *
     * @return Cocktail
     */
    public function addIngredient($ingredient)
    {
        $ingredient->addCocktail($this);
        $this->ingredients->add($ingredient);

        return $this;
    }

    /**
     * Remove ingredient.
     *
     * @param $ingredient
     */
    public function removeIngredient($ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return Cocktail
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }
}
