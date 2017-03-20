
-- Host: 127.0.0.1
-- Wersja PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `blogapp`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `country` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `course` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invest` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `comments` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `registrations`
--

INSERT INTO `registrations` (`id`, `name`, `email`, `sex`, `birthdate`, `country`, `course`, `invest`, `comments`) VALUES
(2, 'Karol Brzozowski', 'brzozowski96@gmail.com', 'm', '1996-11-03', 'PL', 'af', 'a:2:{i:0;s:1:\"a\";i:1;s:1:\"o\";}', 'Nie mogę się już doczekać :)'),
(3, 'Michał Nowak', 'brzozowski96@gmail.com', 'm', NULL, 'DE', 'basic', 'a:2:{i:0;s:1:\"o\";i:1;s:3:\"etf\";}', NULL),
(4, 'Barbara Brzozowska', 'brzozowski96@gmail.com', 'f', '1971-03-17', 'JP', 'at', 'a:3:{i:0;s:1:\"o\";i:1;s:1:\"f\";i:2;s:3:\"etf\";}', 'Dziękuję za ogranizację szkolenia');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
