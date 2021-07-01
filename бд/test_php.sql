-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 02 2021 г., 00:02
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test_php`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Деловые/Бизнес-процессы', '0000-00-00', '0000-00-00'),
(2, 'Деловые/Найм', '0000-00-00', '0000-00-00'),
(3, 'Деловые/Реклама', '0000-00-00', '0000-00-00'),
(4, 'Деловые/Управление бизнесом', '0000-00-00', '0000-00-00'),
(5, 'Деловые/Управление людьми', '0000-00-00', '0000-00-00'),
(6, 'Деловые/Управление проектами', '0000-00-00', '0000-00-00'),
(7, 'Детские/Воспитание', '0000-00-00', '0000-00-00'),
(8, 'Дизайн/Общее', '0000-00-00', '0000-00-00'),
(9, 'Дизайн/Logo', '0000-00-00', '0000-00-00'),
(10, 'Дизайн/Web дизайн', '0000-00-00', '0000-00-00'),
(11, 'Разработка/PHP', '0000-00-00', '0000-00-00'),
(12, 'Разработка/HTML и CSS', '0000-00-00', '0000-00-00'),
(13, 'Разработка/Проектирование', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Структура таблицы `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `fk_id_material` int(11) NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `links`
--

INSERT INTO `links` (`id`, `fk_id_material`, `name`, `link`, `created_at`, `updated_at`) VALUES
(2, 1, 'Поиск в google', 'https://www.google.com/search?client=opera&q=путь+джедая&sourceid=opera&ie=UTF-8&oe=UTF-8', '2021-07-01', '2021-07-01');

-- --------------------------------------------------------

--
-- Структура таблицы `material`
--

CREATE TABLE `material` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `fk_id_type` int(11) NOT NULL,
  `fk_id_category` int(11) NOT NULL,
  `autors` text DEFAULT '-',
  `description` text NOT NULL DEFAULT '-',
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `material`
--

INSERT INTO `material` (`id`, `name`, `fk_id_type`, `fk_id_category`, `autors`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Путь джедая', 1, 5, 'Максим Дорофеев', 'Почитать стоит для личного роста', '2021-07-01', '2021-07-01'),
(6, 'Как повысить доход', 2, 1, 'Марк Тишман', 'Научитесь зарабатывать деньги', '2021-07-01', '2021-07-01'),
(7, 'Воспитание ребенка', 1, 7, 'Мария Кузнецова', 'Воспитание ребенка от года до 5 лет', '2021-07-01', '2021-07-01'),
(8, 'Как кормить ребенка', 3, 7, 'Мария Кузнецова', 'В этом видео я научу вас кормить ребенка', '2021-07-01', '2021-07-01');

-- --------------------------------------------------------

--
-- Структура таблицы `teg`
--

CREATE TABLE `teg` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teg`
--

INSERT INTO `teg` (`id`, `name`, `created_at`, `updated_at`) VALUES
(3, 'Продуктивность', '2021-07-01', '2021-07-01'),
(4, 'Личная эффективность', '2021-07-01', '2021-07-01'),
(7, 'Ребенок', '2021-07-01', '2021-07-01'),
(8, 'Воспитание', '2021-07-01', '2021-07-01'),
(9, 'Финансы', '2021-07-01', '2021-07-01'),
(10, 'Деньги', '2021-07-01', '2021-07-01');

-- --------------------------------------------------------

--
-- Структура таблицы `tegs_material`
--

CREATE TABLE `tegs_material` (
  `id` int(11) NOT NULL,
  `fk_id_teg` int(11) NOT NULL,
  `fk_id_material` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tegs_material`
--

INSERT INTO `tegs_material` (`id`, `fk_id_teg`, `fk_id_material`, `created_at`, `updated_at`) VALUES
(1, 3, 1, '2021-07-01', '2021-07-01'),
(8, 4, 1, '2021-07-01', '2021-07-01'),
(9, 9, 6, '2021-07-01', '2021-07-01'),
(10, 10, 6, '2021-07-01', '2021-07-01'),
(11, 8, 7, '2021-07-01', '2021-07-01'),
(12, 7, 7, '2021-07-01', '2021-07-01'),
(13, 7, 8, '2021-07-01', '2021-07-01');

-- --------------------------------------------------------

--
-- Структура таблицы `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `type`
--

INSERT INTO `type` (`id`, `name`) VALUES
(1, 'Книга'),
(2, 'Статья'),
(3, 'Видео'),
(4, 'Сайт/Блог'),
(5, 'Подборка'),
(6, 'Ключевые идеи книги');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `teg`
--
ALTER TABLE `teg`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tegs_material`
--
ALTER TABLE `tegs_material`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `material`
--
ALTER TABLE `material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `teg`
--
ALTER TABLE `teg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `tegs_material`
--
ALTER TABLE `tegs_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
