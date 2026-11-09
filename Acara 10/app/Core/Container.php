<?php

namespace App\Core;

use ReflectionClass;
use ReflectionNamedType;
use RuntimeException;

/**
 * Container Dependency Injection sederhana.
 *
 * Contoh: MahasiswaController butuh MahasiswaRepository,
 * MahasiswaRepository butuh Database. Container membaca type-hint
 * di constructor lalu membuat object-object itu secara berantai:
 *
 *     Database -> MahasiswaRepository -> MahasiswaController
 */
class Container
{
    /** @var array<string, object> object yang dipakai bersama (satu koneksi saja) */
    private array $instances = [];

    /** Class yang cukup dibuat satu kali */
    private array $shared = [Database::class];

    public function make(string $class): object
    {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }

        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $dependencies = [];

        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $param) {
                $type = $param->getType();

                if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                    $dependencies[] = $this->make($type->getName());
                } elseif ($param->isDefaultValueAvailable()) {
                    $dependencies[] = $param->getDefaultValue();
                } else {
                    throw new RuntimeException(
                        "Container tidak bisa membuat {$class}: parameter \${$param->getName()} tidak diketahui."
                    );
                }
            }
        }

        $object = $reflection->newInstanceArgs($dependencies);

        if (in_array($class, $this->shared, true)) {
            $this->instances[$class] = $object;
        }

        return $object;
    }
}
