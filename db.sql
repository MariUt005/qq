-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Апр 23 2023 г., 10:57
-- Версия сервера: 10.11.2-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pos`
--

-- --------------------------------------------------------

--
-- Структура таблицы `access`
--

CREATE TABLE `access` (
  `id` int(10) NOT NULL,
  `login` varchar(50) NOT NULL,
  `tochka_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `access`
--

INSERT INTO `access` (`id`, `login`, `tochka_code`) VALUES
(21, 'utenkova', 'тест1');

-- --------------------------------------------------------

--
-- Структура таблицы `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `fio` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tochka_code` varchar(191) DEFAULT NULL,
  `pass` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `agents`
--

INSERT INTO `agents` (`id`, `login`, `fio`, `password`, `tochka_code`, `pass`) VALUES
(5, 'utenkova', 'Утенкова Мария Александровна', '$2y$10$JUsEQ40fQpHcuNIjevkbteepSoKOTqLMYP.SfihmksZ94.QlKLd1W', NULL, NULL),
(6, 'skorovarov', 'Скороваров Илья Александрович', '$2y$10$Y8eKPdRRcWKXg4wcot20r.isCIhsDryZPZ22zxnXhMwL.3eenKvo6', NULL, NULL),
(8, 'egamov', 'Эгамов Руслан Балтаязович', '$2y$10$8KqkGg4MbYrit0fpv5vmA.FtfLKWXo2wUDXfTaFkOH5zhfiW7xqEy', NULL, NULL),
(9, 'test', 'Тестовый агент', '$2y$10$dwBvKd4Yz4X8BUnqoQUCEu9YpfLhYh3vEwTmz/16M30qlbdMcD1Vm', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `shop`
--

CREATE TABLE `shop` (
  `name` varchar(50) NOT NULL,
  `id` int(10) NOT NULL,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `shop`
--

INSERT INTO `shop` (`name`, `id`, `code`) VALUES
('ООО \"Ромашка\"', 14, '1'),
('ООО \"Еж-маркер\"', 16, '3'),
('ООО \"Абракадабра\"', 17, 'somemagic-1'),
('Тестовый магазин', 18, '1234АБВГ');

-- --------------------------------------------------------

--
-- Структура таблицы `tochka`
--

CREATE TABLE `tochka` (
  `shop_code` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `id` int(10) NOT NULL,
  `tochka_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tochka`
--

INSERT INTO `tochka` (`shop_code`, `name`, `id`, `tochka_code`) VALUES
('1', 'Ромашка-3', 19, '3'),
('1234АБВГ', 'Тестовая точка 1', 21, 'тест1');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tochka`
--
ALTER TABLE `tochka`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `access`
--
ALTER TABLE `access`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `tochka`
--
ALTER TABLE `tochka`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
