-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 27 2025 г., 07:28
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `restaurant_site`
--

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `name`, `phone`, `order_text`, `created_at`) VALUES
(1, 'alex', '32313312213', '31', '2025-05-20 15:33:40'),
(2, '3231', '32313312213', '3213131', '2025-05-20 17:27:45'),
(3, 'alex', '+7 (925) 889-47-93', '2', '2025-05-20 18:06:36'),
(4, 'alex', '+7 (925) 889-47-93', 'курицу', '2025-05-25 09:34:19'),
(5, '3231', '+7 (925) 889-47-93', '44', '2025-05-25 21:45:40');

-- --------------------------------------------------------

--
-- Структура таблицы `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `table_number` int(11) NOT NULL,
  `people` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `name`, `date`, `time`, `table_number`, `people`) VALUES
(1, 1, 'alex', '3232-03-22', '23:32:00', 2, 1),
(2, 1, 'alex', '3232-03-22', '23:32:00', 2, 1),
(3, 4, 'alex', '0023-03-23', '23:23:00', 23, 2),
(4, 1, '32131', '0323-02-02', '03:23:00', 33, 4),
(5, 1, '32131', '0323-02-02', '03:23:00', 33, 4),
(6, 1, 'alex', '2442-02-04', '03:21:00', 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, '79258894793', '$2y$10$natHZhe4xfA6NrFo.XzDjeLoD/30qI.60hf8OdA9ems9mnomopZQK'),
(2, 'dfdf', '$2y$10$2wMKYTu32NoK/wuECEcEAOpyHix/UQo/tzAqNtbOp9rYOBvOP7wGu'),
(3, 'rrr', '$2y$10$Czu5/qYuTJhBW4JCDja45OB7hT7GTgzqPw4CQIDuaCVOyui7MUvqe'),
(4, 'eee', '$2y$10$wDBFCanEmxFKRaSrTEKfsu53fIblvPxpt5rF6DdHZkVtlBsPNMcwO'),
(5, 'ttt', '$2y$10$kowD8yIUsk4sS00PsjoQ.uynXkxiDaR5eQEG0kbOFpBY0sJ1Y6rbK'),
(6, 'привет', '$2y$10$zIi509jpy.oM6xxnMQSeY.wxUpxza5LuZOJXFhPGvhiD0eYLoR42e'),
(7, 'пока', '$2y$10$PAM9JUV1AEazKYoJ0yC3LuA5NlEVc3/KjpvXhUXCGcc3XGMaPfwJ.');

-- --------------------------------------------------------

--
-- Структура таблицы `user_orders`
--

CREATE TABLE `user_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_orders`
--

INSERT INTO `user_orders` (`id`, `user_id`, `order_text`, `created_at`) VALUES
(1, 1, '332', '2025-05-26 11:25:35'),
(2, 1, 'rehbwf', '2025-05-26 14:50:58'),
(3, 5, '123', '2025-05-26 14:51:46'),
(4, 1, '3232', '2025-05-26 15:01:24');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_orders`
--
ALTER TABLE `user_orders`
  ADD CONSTRAINT `user_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
