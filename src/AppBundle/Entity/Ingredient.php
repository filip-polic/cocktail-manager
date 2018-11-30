<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredients")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IngredientRepository")
 * @UniqueEntity("name", message="Ingredient with the same name already exists.")
 */
class Ingredient
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
     * @var ArrayCollection
     * @Serializer\MaxDepth(2)
     * @Serializer\Groups("ingredient_show")
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Cocktail", mappedBy="ingredients")
     * @ORM\JoinColumn(name="cocktail_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $cocktails;

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
     * @return Ingredient
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
     * @return ArrayCollection
     */
    public function getCocktails()
    {
        return $this->cocktails;
    }

    /**
     * Add cocktail.
     *
     * @param Cocktail $cocktail
     *
     * @return Ingredient
     */
    public function addCocktail($cocktail)
    {
        $this->cocktails->add($cocktail);

        return $this;
    }

    /**
     * Remove cocktail.
     *
     * @param $cocktail
     */
    public function removeCocktail($cocktail)
    {
        $this->cocktails->removeElement($cocktail);
    }

    public function __construct()
    {
        $this->cocktails = new ArrayCollection();
    }
}
