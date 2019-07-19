<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 29.09.2018
 * Time: 10:17
 */
namespace Bitkit\Core\Patterns;
abstract class Singleton
{
    protected static $instance = NULL; // Единственный экземпляр класса, чтобы не создавать множество подключений
    //protected static $instance = []; // Единственный экземпляр класса, чтобы не создавать множество подключений

    /* Получение экземпляра класса. Если он уже существует, то возвращается, если его не было, то создаётся и возвращается (паттерн Singleton) */


    public static function getInstance() {
        if (static::$instance === NULL){
            static::$instance = new static();
        }
        return static::$instance;

    }


    /**
     * Клонирование запрещено
     */
    private function __clone()
    {
    }

    /**
     * Сериализация запрещена
     */
    private function __sleep()
    {
    }

    /**
     * Десериализация запрещена
     */
    private function __wakeup()
    {
    }

}