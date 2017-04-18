<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use WorkSpace\PersonService\Entity\Customer;
use WorkSpace\PersonService\Entity\Meal;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    /** @var Customer[] */
    private $customers = [];

    /** @var Meal[] */
    private $meals = [];


    public function __construct()
    {

    }

    /**
     * @Given there is a customer called :firstName
     */
    public function thereIsACustomerCalled(string $firstName)
    {
        //this->person = new Person($firstName, 'Baloo', new DateTime(1981-06-23), "5'7", 'Blue', 'M', ['']);
        $this->customers[$firstName] = new Customer($firstName, 'nunchuckbaloo@gmail.com', ['']);
    }

    /**
     * @Given there is a meal with the menu number :menuNumber
     */
    public function thereIsAMealWithTheMenuNumber(int $menuNumber)
    {
        $this->meals[$menuNumber] = new Meal('Butternut squash ravioli', 5.95, 35, 40, 12, $menuNumber);
    }

    /**
     * @Given :firstName has no starred meals
     */
    public function someoneHasNoStarredMeals($firstName)
    {

    }

    /**
     * @When :firstName stars a meal with the menu number :menuNumber
     */
    public function someoneStarsAMealWithTheMenuNumber($firstName, $menuNumber)
    {
        $customer = $this->customers[$firstName];
        $meal = $this->meals[$menuNumber];
        $customer->starredMeals($meal);

    }

    /**
     * @Then :firstName should have a starred meal with the menu number :menuNumber
     */
    public function someoneShouldHaveAStarredMealWithTheMenuNumber($firstName, $menuNumber)
    {
        $customer = $this->customers[$firstName];
        $meal = $this->meals[$menuNumber];
        $customer->hasStarred($meal);
    }

    /**
     * @Given :firstName has starred a meal with the menu number :menuNumber
     */
    public function someoneHasStarredAMealWithTheMenuNumber($firstName, $menuNumber)
    {
        $customer = $this->customers[$firstName];
        $meal = $this->meals[$menuNumber];

        try {
            $customer->hasStarred($meal);
        } catch (Exception $exception) {
            // Do Nothing
        }
    }

    /**
     * @When :firstName attempts to star the meal with the menu number :menuNumber
     */
    public function someoneAttemptsToStarTheMealWithTheMenuNumber($firstName, $menuNumber)
    {
        $customer = $this->customers[$firstName];
        $meal = $this->meals[$menuNumber];

        try {
            $customer->starredMeals($meal);
        } catch (Exception $exception) {
            // Do Nothing
        }
    }

    /**
     * @When :firstName unstars the meal with the menu number :menuNumber
     */
    public function someoneUnstarsTheMealWithTheMenuNumber($firstName, $menuNumber)
    {
        $customer = $this->customers[$firstName];
        $meal = $this->meals[$menuNumber];
        $customer->starredMeals($meal);

        $mealToCheck = $this->meals[$menuNumber];
        $hasStarred = $customer->hasStarred($mealToCheck);

        if ($hasStarred == true) {
            $customer->removeStarredMeals($mealToCheck);
        } else {
            throw new \Exception('Meal has not yet been starred');
        }
    }

    /**
     * @Then :firstName should not have a starred meal with the menu number :menuNumber
     */
    public function someoneShouldNotHaveAStarredMealWithTheMenuNumber($firstName, $menuNumber)
    {
        $customer = $this->customers[$firstName];
        $mealToCheck = $this->meals[$menuNumber];
        $hasStarred = $customer->hasStarred($mealToCheck);

        if ($hasStarred == true) {
            throw new Exception(('Customer has starred a meal'));
        }
    }
}
