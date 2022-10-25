<?php

namespace App\Factory;

use App\Entity\Advert;
use App\Repository\AdvertRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Advert>
 *
 * @method static Advert|Proxy createOne(array $attributes = [])
 * @method static Advert[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Advert[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Advert|Proxy find(object|array|mixed $criteria)
 * @method static Advert|Proxy findOrCreate(array $attributes)
 * @method static Advert|Proxy first(string $sortedField = 'id')
 * @method static Advert|Proxy last(string $sortedField = 'id')
 * @method static Advert|Proxy random(array $attributes = [])
 * @method static Advert|Proxy randomOrCreate(array $attributes = [])
 * @method static Advert[]|Proxy[] all()
 * @method static Advert[]|Proxy[] findBy(array $attributes)
 * @method static Advert[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Advert[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AdvertRepository|RepositoryProxy repository()
 * @method Advert|Proxy create(array|callable $attributes = [])
 */
final class AdvertFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'title' => self::faker()->text(),
            'description' => self::faker()->text(),
            'price' => self::faker()->randomNumber(),
            'createdAt' => self::faker()->dateTime(), // TODO add DATETIME ORM type manually
            'slug' => self::faker()->text(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Advert $advert): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Advert::class;
    }
}
