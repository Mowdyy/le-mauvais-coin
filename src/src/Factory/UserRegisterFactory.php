<?php

namespace App\Factory;

use App\Entity\UserRegister;
use App\Repository\UserRegisterRepository;
use Symfony\Component\Validator\Constraints\Email;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends ModelFactory<UserRegister>
 *
 * @method static UserRegister|Proxy createOne(array $attributes = [])
 * @method static UserRegister[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static UserRegister[]|Proxy[] createSequence(array|callable $sequence)
 * @method static UserRegister|Proxy find(object|array|mixed $criteria)
 * @method static UserRegister|Proxy findOrCreate(array $attributes)
 * @method static UserRegister|Proxy first(string $sortedField = 'id')
 * @method static UserRegister|Proxy last(string $sortedField = 'id')
 * @method static UserRegister|Proxy random(array $attributes = [])
 * @method static UserRegister|Proxy randomOrCreate(array $attributes = [])
 * @method static UserRegister[]|Proxy[] all()
 * @method static UserRegister[]|Proxy[] findBy(array $attributes)
 * @method static UserRegister[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static UserRegister[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static UserRegisterRepository|RepositoryProxy repository()
 * @method UserRegister|Proxy create(array|callable $attributes = [])
 */
final class UserRegisterFactory extends ModelFactory
{
    private $hasher;


    public function __construct(UserPasswordHasherInterface $hasher)
    {
        parent::__construct();

        $this->hasher = $hasher;

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'email' => self::faker()->email(),
            'userName' => self::faker()->name(),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'city' => self::faker()->word(),
            'phoneNumber' => self::faker()->phoneNumber(),
            'zipCode' => self::faker()->word(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this->afterInstantiate(function (UserRegister $userRegister): void {
            $userRegister->setPassword($this->hasher->hashPassword($userRegister, 'password'));
            if (rand(1, 2) === 1) {
                $userRegister->setRoles(['ROLE_ADMIN']);
            }
        });
    }

    protected static function getClass(): string
    {
        return UserRegister::class;
    }
}
