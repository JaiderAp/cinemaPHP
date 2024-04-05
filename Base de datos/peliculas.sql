-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-04-2024 a las 00:02:22
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cinema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculas`
--

CREATE TABLE `peliculas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `cartelera` text DEFAULT NULL,
  `elenco` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `peliculas`
--

INSERT INTO `peliculas` (`id`, `nombre`, `descripcion`, `cartelera`, `elenco`, `created_at`, `updated_at`) VALUES
(1, 'Diamantes en bruto', 'Un carismático joyero hace una apuesta de alto riesgo que podría conducir a una ganancia inesperada, pero antes debe lograr un equilibrio entre las empresas, la familia y los adversarios.', '1712267949_diamantes-en-bruto.jpg', 'Adam Sandler, Julia Fox, Lakeith Stanfield y Idina Menzel', NULL, NULL),
(2, 'Parásitos', 'Tanto Gi Taek como su familia están sin trabajo. Cuando su hijo mayor, Gi Woo, empieza a impartir clases particulares en la adinerada casa de los Park, las dos familias, que tienen mucho en común pese a pertenecer a dos mundos totalmente distintos, entablan una relación de resultados imprevisibles.', '1712267978_Parasitos.jpg', 'Lee Sun-kyun, Cho Yeo-jeong, Choi Woo-shik, Park Seo-joon, Song Kang-ho, Park Myung-hoon, Jang Hye-jin', NULL, NULL),
(3, 'The Great Gatsby', 'Jay Gatsby es un héroe trágico que se va destruyendo conforme se acerca a su sueño: la reconquista de una mujer a la que dejó para irse a la guerra en Europa. Quiere cumplir su deseo más inaccesible: recuperar el pasado, el momento en que conquistó a Daisy Buchanan.', '1712268005_Gatsby.jpg', 'Leonardo DiCaprio, Carey Mulligan, Elizabeth Debicki, Jason Clarke, Amitabh Bachchan, Barry Otto, Steve Bisley, Callan McAuliffe, Lisa Adam, Sean Hape, Vince Colosimo, Max Cullen, Stephen James King, sophie holloway y Kahlia Greksa', NULL, NULL),
(4, 'El Exorcista', 'Adaptación de la novela de William Peter Blatty. Inspirada en un exorcismo real ocurrido en Washington en 1949. Regan, una niña de doce años, es víctima de fenómenos paranormales. Su madre, aterrorizada, tras someter a su hija a múltiples análisis médicos que no ofrecen ningún resultado, acude a un sacerdote con estudios de psiquiatría. Éste está convencido de que la niña es víctima de una posesión diabólica. Por eso, con la ayuda de otro sacerdote, decide practicar un exorcismo.', '1712268058_El_exorcista_(Película).jpg', 'Ellen Burstyn, Max von Sydow, Linda Blair, Jason Miller, Lee J. Cobb, Kitty Winn', NULL, NULL),
(5, 'Interestelar', 'Un grupo de científicos y exploradores, encabezados por Cooper, se embarcan en un viaje espacial para encontrar un lugar con las condiciones necesarias para reemplazar a la Tierra y comenzar una nueva vida allí. La Tierra está llegando a su fin y este grupo necesita encontrar un planeta más allá de nuestra galaxia que garantice el futuro de la raza humana.', '1712268083_Interstellar.jpg', 'Matthew McConaughey, Anne Hathaway, Jessica Chastain, Michael Caine, Casey Affleck, Mackenzie Foy, Timothée Chalamet, David Gyasi, Wes Bentley, John Lithgow, y Matt Damon.', NULL, NULL),
(6, 'Mario Bors', 'Dos hermanos plomeros, Mario y Luigi, caen por las alcantarillas y llegan a un mundo subterráneo mágico en el que deben enfrentarse al malvado Bowser para rescatar a la princesa Peach, quien ha sido forzada a aceptar casarse con él.', '1712268114_MarioBros.jpg', 'Bob Hoskins, John Leguizamo, Dennis Hopper, Samantha Mathis, Fisher Stevens, Richard Edson, Fiona Shaw, Mojo Nixon, Dana Kaminski, y Gianni Russo.', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
