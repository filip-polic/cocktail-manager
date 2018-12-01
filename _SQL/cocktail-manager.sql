-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 01, 2018 at 04:03 AM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cocktail-manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `cocktails`
--

CREATE TABLE `cocktails` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(640) COLLATE utf8_unicode_ci NOT NULL,
  `preparation` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `difficulty` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cocktails`
--

INSERT INTO `cocktails` (`id`, `name`, `description`, `preparation`, `difficulty`, `user_id`) VALUES
(4, 'Long Island Iced Tea', 'The story of the Long Island Iced Tea is shrouded in mystery. But rest assured this drink is easy to master, if only one can say the same for the morning after.', 'Fill a highball or hurricane glass with ice and add all the ingredients except the cola.\r\nTop with a splash of cola and stir briefly.\r\nGarnish with a lemon wedge.', 'Easy', 4),
(5, 'Gin Fizz', 'Love the Tom Collins? Try its frothy, bubbly cousin, the Gin Fizz. The secret to creating the perfect creaminess and froth is to shake, shake, shake—and then shake some more.', 'Add the club soda to a Fizz or Collins glass and set aside.\r\n\r\nAdd the remaining ingredients into a shaker and dry-shake (without ice) for about 10 seconds.\r\n\r\nAdd 3 or 4 ice cubes and shake very well.\r\n\r\nDouble-strain into the prepared glass.', 'Medium', NULL),
(17, 'Tom Collins', 'The Tom Collins is essentially a sparkling lemonade spiked with a healthy dose of the juniper spirit. While there is a debate which side of the pond this drink was born, this cocktail lives up to his classic status with every sip.', 'Add the lemon juice, simple syrup and gin into a shaker with ice and shake well.\r\n\r\nStrain into a highball or Collins glass over fresh ice.\r\n\r\nTop with club soda.\r\n\r\nGarnish with a lemon wheel and cherry, and serve with a straw.', 'Easy', NULL),
(18, 'Bombilla', 'At rum-centric restaurant Ronero in Chicago, the kitchen focuses on Latin American cuisine, including Argentinean, so having a yerba mate cocktail was a no-brainer. Bartender Allie Kim combines Old Forester signature bourbon with Bénédictine, stone ground yerba mate syrup, lemon and mint for a refreshingly herbaceous cocktail that works year-round. Meaning “lightbulb,” “little pump” and “straw” in Spanish, it takes its name from the metal straw yerba mate is usually sipped from, which allows yerba mate to be served loose-leaf without consuming any large particles.', 'Add all the ingredients into a shaker with ice and shake.\r\n\r\nFine-strain over fresh ice in a rocks glass.\r\n\r\nGarnish with a mint sprig.\r\n\r\n*Stone-ground yerba mate syrup: Add 1/4 cup stone-ground yerba mate, 4 cups granulated sugar and 4 cups hot water into a saucepan over medium heat, and stir for about 10 minutes until evenly saturated and sugar is dissolved. Let cool.', 'Medium', NULL),
(21, 'Dry Martini', 'The Dry Martini is a classic cocktail that, like a tailored suit, is timeless. Although the original of the tipple is unclear, the Dry Martini has maintained a place in cocktail history due to being easy to use and endlessly sophisticated. Elegant for the fancy and boozy for the heavy-handed, this potation is truly the everyman’s cocktail.', 'Add all the ingredients into a mixing glass with ice and stir until very cold.\r\n\r\nStrain into a chilled cocktail glass.\r\n\r\nGarnish with a lemon twist.', 'Medium', NULL),
(22, 'Manhattan', 'The Manhattan was the most famous cocktail in the world shortly after it was invented in New York City’s Manhattan Club, some time around 1880 (as the story goes). Over the years, the whiskey classic has dipped in and out of fashion before finding its footing as one of the cornerstones of the craft cocktail renaissance.', 'Add all the ingredients into a mixing glass with ice, and stir until well-chilled.\r\n\r\nStrain into a chilled coupe.\r\n\r\nGarnish with a brandied cherry.', 'Easy', NULL),
(24, 'Martinez', 'Grandfather to the modern martini, the Martinez is a drink of gin (Old Tom, if you can; try Ransom or Hayman\'s), sweet vermouth, maraschino or curaçao, and bitters. It\'s a sweeter drink than the typical dry martini, but the flavor is complex and refreshing. Assembling the ingredients requires some outlay of funds, but if you\'re within spitting distance of a respectable craft-cocktail bar, you should be able to sample one there.', 'Fill a mixing glass with ice. Add gin, sweet vermouth, maraschino liqueur, and orange bitters. Stir until very cold then strain into a chilled cocktail glass. Twist lemon peel over cocktail to express its oils. Rub rim of glass with peel and discard.', 'Medium', 5),
(26, 'Daiquiri', 'No drink has suffered more abuse than the Daiquiri. In the roughly 130 years since its inception, the granddaddy of rum cocktails has gone from the pride of Havana to an unloved extra on the back of a Señor Frog’s table tent. Even today, as the craft cocktail movement reaches full tilt, most people too often associate the Daiquiri with adult slushies, the stuff of spring break blackouts and mind-splitting hangovers.', 'Pour sugar and lime juice into a cocktail shaker and stir until sugar is dissolved. Add the rum and fill shaker with ice; shake well for 10 seconds and strain into a chilled cocktail glass. Garnish with a wedge of lime.', 'Medium', 4),
(27, 'Margarita', 'The Margarita, like so many drinks in the cocktail canon, comes with a fuzzy origin story. Was it first dreamed up by a Tijuana bartender in the late-1930s? Or did a Texas socialite invent it 10 years later at her Acapulco villa?\r\n\r\nShort answer: It doesn’t matter. What matters is that someone, somewhere summoned the sacred mixture of tequila, lime, orange liqueur and sugar and gifted it to the world. Our love affair with the Margarita has endured for more than 70 years, even as we’ve often saddled it with our most dubious creative impulses.', 'Run lime wedge around the outer rims of two rocks glasses and dip rims in salt. Set aside.\r\n\r\nIn cocktail shaker, combine tequila, Cointreau, and lime juice. Fill with ice and shake until thoroughly chilled, about 15 seconds (the bottom of a metal shaker should frost over).\r\n\r\nFill glasses with fresh ice and strain margarita into both glasses. Garnish with lime wheels and serve.', 'Medium', NULL),
(30, 'Bloody Mary', 'The Bloody Mary is a vodka-soaked nutritional breakfast and hangover cure all in one. What else could you ask for?\r\n\r\nThe tomato-based cocktail has hundreds of variations, from heavy on the hot sauce to a splash of Guinness on top. It’s best to start with the classic recipe and work toward the way you like it, even if it’s topped with a shrimp skewer, a slice of bacon and a tiny cheeseburger. Crazy garnishes aside, there’s a reason this iconic beverage is a classic.\r\n\r\nWhile the origin of this popular brunch cocktail is debatable, the Bloody Mary’s staying power leaves no question.', 'Pour some celery salt onto a small plate.\r\n\r\nRub the juicy side of the lemon or lime wedge along the lip of a pint glass.\r\n\r\nRoll the outer edge of the glass in celery salt until fully coated.\r\n\r\nFill with ice and set aside.\r\n\r\nSqueeze the lemon and lime wedges into a shaker and drop them in.\r\n\r\nAdd the remaining ingredients and ice and shake gently.\r\n\r\nStrain into the prepared glass.\r\n\r\nGarnish with a parsley sprig and 2 speared green olives and a lime wedge.', 'Hard', NULL),
(31, 'Irish coffee', 'The secrets to making a great Irish Coffee are really so simple that they are often overlooked. This hot, creamy, classic Irish Coffee recipe from legendary bartender Dale DeGroff has all the right ingredients and will warm you to the bone.', 'Add the whiskey and syrup to an Irish Coffee glass and fill two-thirds of the way with coffee.\r\n\r\nTop with one inch of whipped cream.', 'Easy', 5),
(32, 'Negroni', 'Easy to make and refreshingly bitter, the Negroni is said to have been invented in Florence by a dauntless Italian count who demanded that the bartender replace the club soda in his Americano with gin. It was a substitution that launched a thousand riffs.\r\n\r\nIn its hundred-year history, few cocktails have encouraged more frenzied experimentation than the beloved Negroni. Its one-to-one-to-one recipe of gin, Campari and sweet vermouth has become the platform on which generations of drink mixers have left their thumbprint.', 'Add all the ingredients into a mixing glass with ice, and stir until well-chilled.\r\n\r\nStrain into a rocks glass filled with large ice cubes.\r\n\r\nGarnish with an orange peel.', 'Medium', 5),
(34, 'Sazerac', 'A close cousin to the Old Fashioned, the Sazerac has been kicking around in one form or another since 1840. In 2008, it was crowned the official cocktail of New Orleans, a designation more suited to marketers than drink mixers. The truth is the Sazerac has always belonged to the Crescent City.\r\n\r\nUp until the late 1800s, it was made with French brandy as a base—Sazerac de Forge et Fils, to be exact—before bartenders switched to rye, the spirit newly arriving by the barge-load down the Mississippi. A well-made Rye Sazerac is indeed a tasty thing, full of spice and depth, though perhaps, we think, a hair too much muscle.', 'Rinse a chilled rocks glass with absinthe, discarding any excess, and set aside.\r\n\r\nIn a mixing glass, muddle the sugar cube, water and both bitters.\r\n\r\nAdd the rye, fill with ice, and stir until well-chilled.\r\n\r\nStrain into the prepared glass.\r\n\r\nTwist a slice of lemon peel over the surface to extract the oils and then discard.', 'Hard', NULL),
(39, 'Uppercut', 'Chivas Regal 12-year-old scotch has plenty of flavor and complexity on its own. All it needs is a little pineapple and lemon juice to brighten it up. Be careful though—it packs quite a punch.', 'Pour all the ingredients into a Collins glass over ice.&#13;&#10;Garnish with a mint sprig and pineapple slice.', 'Easy', 4),
(40, 'Barcelona\'s Painkiller', 'The Painkiller is already a twist on the Piña Colada, but you can elevate the recipe even further by swapping high-quality spanish brandy for rum. That’s precisely what Johnny Livanos has done with this innovative and mouthwatering cocktail.', 'Add all ingredients to a shaker with ice and shake until well-chilled. \r\nStrain into a tiki mug filled with crushed ice and top with more crushed ice.\r\n\r\nGarnish with grated nutmeg and mint sprig.', 'Medium', 4);

-- --------------------------------------------------------

--
-- Table structure for table `cocktail_ingredient`
--

CREATE TABLE `cocktail_ingredient` (
  `cocktail_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cocktail_ingredient`
--

INSERT INTO `cocktail_ingredient` (`cocktail_id`, `ingredient_id`) VALUES
(4, 27),
(5, 30),
(17, 21),
(17, 22),
(17, 32),
(21, 4),
(21, 5),
(21, 17),
(22, 5),
(24, 4),
(26, 2),
(26, 48),
(26, 49),
(30, 18),
(31, 18),
(32, 18),
(39, 20),
(39, 67),
(39, 68),
(40, 34),
(40, 68),
(40, 69),
(40, 70);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`) VALUES
(4, 'Agave syrup'),
(42, 'Amaro'),
(37, 'Angostura bitters'),
(63, 'Apple brandy'),
(28, 'Beer'),
(30, 'Benedictine'),
(1, 'Blanco tequila'),
(38, 'Bourbon of rye'),
(47, 'Brown sugar cube'),
(56, 'Brown sugar syrup'),
(59, 'Campari'),
(12, 'Celery salt'),
(53, 'Champagne'),
(67, 'Chivas Regal 12-year-old scotch'),
(19, 'Club soda'),
(26, 'Coca Cola'),
(57, 'Coffee'),
(50, 'Cognac'),
(51, 'Cointreau'),
(46, 'Cold water'),
(70, 'Cream of coconut'),
(49, 'Demerara sugar syrup'),
(16, 'Dry vermouth'),
(22, 'Egg white'),
(20, 'Fresh lemon juice'),
(2, 'Fresh lime juice'),
(15, 'Gin'),
(35, 'Grade B maple syrup'),
(54, 'Green olives'),
(13, 'Ground black pepper'),
(55, 'Jameson whiskey'),
(33, 'Laird\'s bonded apple brandy'),
(5, 'Lemon wedge'),
(48, 'Light rum'),
(6, 'Lime wedge'),
(44, 'Luxardo maraschino liqueur'),
(41, 'Maraschino liqueur'),
(32, 'Mint'),
(29, 'Old Forester Bourbon'),
(43, 'Old Tom gin'),
(17, 'Orange bitters'),
(34, 'Orange Juice'),
(3, 'Orange liqueur'),
(60, 'Orange twist'),
(61, 'Peychaud’s bitters'),
(68, 'Pineapple juice'),
(10, 'Prepared horseradish'),
(62, 'Pumpkin purée'),
(27, 'Rum'),
(40, 'Rye whiskey'),
(24, 'Silver tequila'),
(21, 'Simple syrup'),
(14, 'Smoked paprika'),
(31, 'Stone-ground yerba mate syrup'),
(52, 'Superfine sugar'),
(39, 'Sweet vermouth'),
(9, 'Tabasco sauce'),
(8, 'Tomato juice'),
(18, 'Tonic water'),
(69, 'Torres 15 Brandy'),
(25, 'Triple sec'),
(58, 'Unsweetened cream'),
(7, 'Vodka'),
(23, 'White rum'),
(45, 'White sugar'),
(11, 'Worcestershire sauce');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_joined` datetime NOT NULL,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `date_joined`, `last_login`) VALUES
(4, 'admin@cocktail-manager.com', 'admin', 'ZaB54haZuJFXlcQUclSUxJHID+ijq6MkVpyJZwp9dxLk4Y/x/cvSGg==', '2018-10-23 10:00:00', '2018-12-01 02:25:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cocktails`
--
ALTER TABLE `cocktails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9ACB90D25E237E06` (`name`),
  ADD KEY `IDX_9ACB90D2A76ED395` (`user_id`);

--
-- Indexes for table `cocktail_ingredient`
--
ALTER TABLE `cocktail_ingredient`
  ADD PRIMARY KEY (`cocktail_id`,`ingredient_id`),
  ADD KEY `IDX_1A2C0A39CD6F76C6` (`cocktail_id`),
  ADD KEY `IDX_1A2C0A39933FE08C` (`ingredient_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4B60114F5E237E06` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_1483A5E9F85E0677` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cocktails`
--
ALTER TABLE `cocktails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
