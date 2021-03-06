<?php

namespace BankiruSchool\DI\Common\Tests\CompileTime;

use BankiruSchool\DI\Common\OptionalDependency;
use BankiruSchool\DI\Common\Tests\Dumper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

abstract class Compile1 extends TestCase
{
    final public function testExtensionPresentIfDependencyPresent()
    {
        $builder = $this->getBuilder();
        $this->configureBuilder($builder);
        $this->addDependency($builder);
        $builder->compile();

        self::assertTrue($builder->has('optional_dependency'));
        self::assertTrue($builder->has('optional_extension'));

        Dumper::dump($builder);
    }

    final public function testExtensionNotPresentIfDependencyNotPresent()
    {
        $builder = $this->getBuilder();
        $this->configureBuilder($builder);
        $builder->compile();

        self::assertFalse($builder->has('optional_dependency'));
        self::assertFalse($builder->has('optional_extension'));

        Dumper::dump($builder);
    }

    abstract protected function configureBuilder(ContainerBuilder $builder);

    private function getBuilder(): ContainerBuilder
    {
        return new ContainerBuilder();
    }

    private function addDependency(ContainerBuilder $builder)
    {
        $builder->register('optional_dependency', OptionalDependency::class);
    }
}
