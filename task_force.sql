-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Июн 19 2022 г., 18:51
-- Версия сервера: 5.5.62
-- Версия PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `task_force`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) NOT NULL,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `url` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `locations`
--

CREATE TABLE `locations` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) NOT NULL,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL,
  `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(100) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `telegram` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `city_id` bigint(100) NOT NULL,
  `avatar_id` bigint(100) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `description` text,
  `current_rating` float DEFAULT NULL,
  `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NULL DEFAULT NULL,
  FOREIGN KEY (city_id)  REFERENCES cities (id),
  FOREIGN KEY (avatar_id)  REFERENCES files (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category_id` bigint(20) NOT NULL,
  `author_id` bigint(20) NOT NULL,
  `executor_id` bigint(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `budget` float NOT NULL,
  `deadline` datetime NOT NULL,
  `location_id`  bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(100) NOT NULL,
  FOREIGN KEY (category_id)  REFERENCES categories (id),
  FOREIGN KEY (author_id)  REFERENCES users (id),
  FOREIGN KEY (executor_id)  REFERENCES users (id),
  FOREIGN KEY (location_id)  REFERENCES locations (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `task_files`
--

CREATE TABLE `task_files` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `task_id` bigint(20) NOT NULL,
  `file_id` bigint(20) NOT NULL,
  FOREIGN KEY (task_id)  REFERENCES tasks (id),
  FOREIGN KEY (file_id)  REFERENCES files (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `author_id` bigint(20) NOT NULL,
  `executor_id` bigint(20) NOT NULL,
  `task_id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  FOREIGN KEY (author_id)  REFERENCES users (id),
  FOREIGN KEY (executor_id)  REFERENCES users (id),
  FOREIGN KEY (task_id)  REFERENCES tasks (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `responses`
--

CREATE TABLE `responses` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `executor_id` bigint(20) NOT NULL,
  `task_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NULL DEFAULT NULL,
  FOREIGN KEY (executor_id)  REFERENCES users (id),
  FOREIGN KEY (task_id)  REFERENCES tasks (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `user_categories`
--

CREATE TABLE `user_categories` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  FOREIGN KEY (user_id)  REFERENCES users (id),
  FOREIGN KEY (category_id)  REFERENCES categories (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
