/*
 Navicat Premium Dump SQL

 Source Server         : mysql
 Source Server Type    : MySQL
 Source Server Version : 80039 (8.0.39)
 Source Host           : localhost:3306
 Source Schema         : shop

 Target Server Type    : MySQL
 Target Server Version : 80039 (8.0.39)
 File Encoding         : 65001

 Date: 25/04/2025 21:25:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `idx_name`(`name` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (4, 'Микроволновки');
INSERT INTO `categories` VALUES (1, 'Стиральные машины');
INSERT INTO `categories` VALUES (3, 'Утюги');
INSERT INTO `categories` VALUES (2, 'Холодильники');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` decimal(10, 2) NULL DEFAULT NULL,
  `id_status` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `orders_statuses`(`id_status` ASC) USING BTREE,
  CONSTRAINT `orders_statuses` FOREIGN KEY (`id_status`) REFERENCES `statuses` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (1, '2024-11-26 17:57:55', 250490.00, 4);
INSERT INTO `orders` VALUES (2, '2024-12-01 23:24:47', 250490.00, 1);
INSERT INTO `orders` VALUES (3, '2024-12-01 16:34:43', 69939.00, 3);
INSERT INTO `orders` VALUES (4, '2024-11-26 14:01:15', 108389.00, 1);
INSERT INTO `orders` VALUES (5, '2024-11-26 14:01:15', 108389.00, 1);
INSERT INTO `orders` VALUES (6, '2024-11-26 17:56:17', 218520.00, 4);
INSERT INTO `orders` VALUES (8, '2024-11-30 19:16:43', 8100.00, 3);
INSERT INTO `orders` VALUES (9, '2024-11-26 14:01:16', 385630.00, 1);
INSERT INTO `orders` VALUES (10, '2024-11-26 14:01:16', 173590.00, 1);
INSERT INTO `orders` VALUES (11, '2024-12-01 23:24:52', 19490.00, 5);
INSERT INTO `orders` VALUES (12, '2024-12-03 15:53:29', 175210.00, 1);
INSERT INTO `orders` VALUES (13, '2024-11-30 19:29:33', 193080.00, 3);
INSERT INTO `orders` VALUES (14, '2024-11-30 19:29:38', 347180.00, 3);
INSERT INTO `orders` VALUES (16, '2024-12-01 23:25:00', 428040.00, 7);
INSERT INTO `orders` VALUES (17, '2024-12-01 23:24:58', 19490.00, 6);
INSERT INTO `orders` VALUES (20, '2024-12-01 16:34:45', 169998.00, 3);
INSERT INTO `orders` VALUES (21, '2025-03-13 23:38:41', 6170.00, 1);
INSERT INTO `orders` VALUES (22, '2025-03-13 23:40:08', 6170.00, 1);

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `price` decimal(10, 2) NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `id_category` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `products_categories`(`id_category` ASC) USING BTREE,
  CONSTRAINT `products_categories` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 45 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 'Стиральная машина LG F2J3NS8W', 38450.00, 'Стиральная машина LG F2J3NS8W белого цвета вмещает в себя до 6 кг белья и предназначена для семьи из 2-3 человек. Она имеет 10 режимов стирки с температурными режимами от 20 до 95 градусов. Блокировка от детей не позволит устройству включиться или переключить режим.', 'img/products/Стиральные машины/Стиральная машина LG F2J3NS8W.png', 1);
INSERT INTO `products` VALUES (2, 'Стиральная машина LEX LWM10714LuxIDD', 173590.00, 'Сенсорная панель управления, подсветка и автоочистка барабанов делают эксплуатацию машины простой и удобной. Модель имеет 16 программ для различных ситуаций: от стирки за 15 минут до высокотемпературной для самой тщательной очистки.', 'img/products/Стиральные машины/Стиральная машина LEX LWM10714LuxIDD.png', 1);
INSERT INTO `products` VALUES (3, 'Стиральная машина узкая Indesit EcoTime IWSB 5105', 19490.00, 'Стиральная машина Indesit IWSB 5105 (CIS) с фронтальной загрузкой на 5 кг удивит своего обладателя широким функционалом, состоящим из 16 программ – таким образом, у вас не возникнет и малейших опасений относительно привлекательного вида одежды из любых типов тканей. Эта домашняя ассистентка поможет получить чистые вещи к определенному времени – просто воспользуйтесь режимом отложенного запуска.', 'img/products/Стиральные машины/Стиральная машина узкая Indesit EcoTime IWSB 5105.png', 1);
INSERT INTO `products` VALUES (4, 'Стиральная машина суперузкая Candy Smart Pro CSO34 106TB1/2-07', 21999.00, 'Стиральной машине Candy Smart Pro CSO34106TB1/2-07 можно безо всяких сомнений доверить стирку до 6 кг белья за один цикл работы. Модель в классическом белом цвете корпуса может быть установлена даже в небольшое помещение за счет небольшой глубины, не превышающей 34 см. Барабан с фронтальной загрузкой располагает системой автовзвешивания: специальные датчики определяют расход воды, электроэнергии и время, которое потребуется для стирки заложенного белья. Сенсорный дисплей с поворотной ручкой обеспечивает простую настройку параметров работы, включая выбор одной из 14 стандартных режимов, регулировку температуры в диапазоне от 20 до 75 градусов и настройку скорости отжима.\r\nПлюсом модели является наличие режима обработки паром, которое позволит освежить одежду, не прибегая к ее стирке.', 'img/products/Стиральные машины/Стиральная машина суперузкая Candy Smart Pro CSO34 106TB1 2-07.png', 1);
INSERT INTO `products` VALUES (5, 'Стиральная машина Hyundai WMSA5201', 9490.00, 'Стиральная машина Hyundai WMSA5201 – полуавтоматическая модель с вертикальным загрузочным люком. За один цикл она позволяет стирать до 5 кг белья. Барабан из нержавеющей стали устойчив к повреждениям и появлению коррозии. В конструкции есть центрифуга для отжима до 2 кг белья.', 'img/products/Стиральные машины/Стиральная машина Hyundai WMSA5201.png', 1);
INSERT INTO `products` VALUES (6, 'Беспроводной утюг Polaris PIR 2444K Cord[LESS]', 3960.00, 'Утюг Polaris PIR 2444K Cord[LESS] оснащен системой равномерного распределения тепла SMART HEAT. Ультрастойкое керамическое покрытие PRO 5 Ceramic.', 'img/products/Утюги/Беспроводной утюг Polaris PIR 2444K Cord[LESS].png', 3);
INSERT INTO `products` VALUES (7, 'Утюг UFESA Perfect Trip', 3430.00, 'Утюг Ufesa PERFECT TRIP благодаря компактной конструкции подходит для поездок. Мощность 1100 Вт и система постоянной подачи пара с интенсивностью 15 г/мин обеспечивают разглаживание складок на разных тканях. Утюг оснащен резервуаром для воды емкостью 70 мл. Для устранения стойких складок предусмотрены функция парового удара 75 г/мин и разбрызгиватель.', 'img/products/Утюги/Утюг UFESA Perfect Trip.png', 3);
INSERT INTO `products` VALUES (8, 'Утюг Gorenje SIH1100TBT', 1620.00, 'Антипригарная тефлоновая подошва хорошо скользит по ткани, быстро и легко разглаживая складки, чтобы ваш гардероб в поездке оставался безукоризненным. Функция парового удара разглаживает самые неподдающиеся заломы и складки. Сухая глажка, глажка с паром или паровой удар — у вас богатый выбор вариантов. Есть даже функция вертикального отпаривания, что особенно удобно в поездке. Не нужно много места, чтобы хорошо выглядеть. Резервуар имеет большой объем 70 миллилитров, чтобы не доливать воду во время глажки. Вы потратите меньше времени и получите больше удовольствия.', 'img/products/Утюги/Утюг Gorenje SIH1100TBT.png', 3);
INSERT INTO `products` VALUES (9, 'Утюг Vitek VT-1209', 3500.00, 'Утюг Vitek VT-1209 BN является качественной и удобной в эксплуатации моделью. Главной особенностью является функция автоматического отключения, срабатывающая после нескольких минут простоя. Предусматривается возможность использования функции вертикального отпаривания, что упрощает уход за верхней одеждой и нежными шторами.\r\nМощность Vitek VT-1209 BN достигает 2200 Вт, что гарантирует эффективную глажку тяжелых тканей. Наличие плавной регуляции температуры позволяет подобрать подходящий режим для глажки нежных и деликатных тканей без повреждений. Керамическая подошва отличается быстрым нагревом и отличным скольжением, что способствует удобной и приятной эксплуатации.', 'img/products/Утюги/Утюг Vitek VT-1209.png', 3);
INSERT INTO `products` VALUES (10, 'Утюг Philips DST7020/20', 8530.00, 'Долговечный утюг благодаря системе Quick Calc Release и подошве SteamGlide Plus с повышенной устойчивостью к царапинам. Система Quick Calc Release для легкой чистки утюга и длительной подачи пара.', 'img/products/Утюги/Утюг Philips DST7020 20.png', 3);
INSERT INTO `products` VALUES (12, 'Холодильник трехкамерный Hitachi R-WB720VUC0 GBK Side by Side', 237680.00, 'Холодильник Hitachi R-WB720VUC0 GBK — премиальная четырехдверная модель с фронтальной панелью из черного стекла. Два независимых вентилятора Dual Fan Cooling поддерживают равномерное охлаждение в холодильном и морозильном отделениях, а система NoFrost не нуждается в размораживании. Электронная система управления на дверце позволяет изменять температурный режим, активировать функции быстрой заморозки и охлаждения.', 'img/products/Холодильники/Холодильник трехкамерный Hitachi R-WB720VUC0 GBK Side by Side.png', 2);
INSERT INTO `products` VALUES (13, 'Холодильник двухкамерный Indesit ITR 4180 W Total No Frost', 33990.00, 'Холодильник Indesit ITR 4180 W общим внутренним объемом 298 литров обеспечивает качественное охлаждение и замораживание различных продуктов. Данная модель обладает двухкамерной конструкцией с расположением морозильного отделения в нижней части и оформлением в белом цвете. Система No Frost исключает необходимость регулярного размораживания и предотвращает образование наледи на стенках или продуктах.', 'img/products/Холодильники/Холодильник двухкамерный Indesit ITR 4180 W Total No Frost.png', 2);
INSERT INTO `products` VALUES (14, 'Холодильник двухкамерный Indesit DS 4180 W', 27990.00, 'Холодильник с морозильником Indesit ITS 4180 W объемом 298 л обладает полками с регулируемым механизмом, который позволяет выбрать подходящую высоту для размещения больших упаковок и посуды. Металлическое внешнее покрытие не подвержено образованию коррозийного налета и повреждений. Ножки в основании служат для устойчивого положения прибора.', 'img/products/Холодильники/Холодильник двухкамерный Indesit DS 4180 W.png', 2);
INSERT INTO `products` VALUES (15, 'Холодильник двухкамерный Gorenje NRR9185EABXLWD Side by Side', 84999.00, 'Холодильник Side by Side Gorenje NRR9185EABXLWD выполнен в черном корпусе с двумя распашными дверцами, которые предоставляют доступ к морозильному и холодильному отделению с общим полезным объемом 588 л. Система No Frost исключает необходимость в регулярном размораживании, так как на стенках не появляются иней и наледь. Технология MultiFlow равномерно распределяет холод. Зона ZeroZone поддерживает свежесть овощей, фруктов, зелени, мяса, полуфабрикатов.', 'img/products/Холодильники/Холодильник двухкамерный Gorenje NRR9185EABXLWD Side by Side.png', 2);
INSERT INTO `products` VALUES (30, 'Микроволновая печь Midea MM720CFB', 6170.00, 'Мощность данной модели составляет 700 Вт при общем энергопотреблении от сети 1050 Вт. Камера покрыта эмалью легкой очистки, что также экономит ваше время. Диаметр поддона, который предоставлен в комплекте – 255 мм.', 'img/products/Микроволновки/Микроволновая печь Midea MM720CFB.png', 4);
INSERT INTO `products` VALUES (31, 'Микроволновая печь Samsung MC28H5013AW/BW', 18999.00, 'Samsung Smart Oven MC28H5013AW предлагает 15 вкусных и полезных для здоровья авторецептов здорового питания. Конвекционный режим позволяет легко и быстро готовить сочные и аппетитные блюда. Вы можете приготовить самые разнообразные блюда, начиная от капусты-брокколи до коричневого риса, от куриных грудок до филе форели.', 'img/products/Микроволновки/Микроволновая печь Samsung MC28H5013AW BW.png', 4);
INSERT INTO `products` VALUES (32, 'Микроволновая печь Hyundai HYM-D3027', 8290.00, 'Микроволновая печь Hyundai HYM-D3027 доведет до необходимой степени готовности и разогреет любые кулинарные изыски без вашего непосредственного участия – вам необходимо лишь активировать функцию таймера. У маленьких детей не окажется доступа к функционалу прибора, ведь он дополнен кнопкой блокировки. Мгновенный выбор среди 8 предложенных программ производится при помощи поворотного переключателя и тактовых элементов.', 'img/products/Микроволновки/Микроволновая печь Hyundai HYM-D3027.png', 4);
INSERT INTO `products` VALUES (33, 'Микроволновая печь Galanz MOS-2003MW', 5700.00, 'Микроволновая Печь Galanz MOS-2003MB обладает эргономичным дизайном, который будет отлично смотреться на любой кухне.', 'img/products/Микроволновки/Микроволновая печь Galanz MOS-2003MW.png', 4);
INSERT INTO `products` VALUES (34, 'Микроволновая печь Samsung MG23T5018AG/BW', 18990.00, 'Микроволновая печь Samsung MG23T5018AG/BW со стандартной 23-литровой камерой подходит для разогревания пищи и приготовления простых блюд. За счет понятной сенсорной панели и безопасности использования разобраться в обращении с этим прибором сможет даже ребенок. Часы, индикатор, дисплей и кнопка быстрого разогрева упрощают применение.', 'img/products/Микроволновки/Микроволновая печь Samsung MG23T5018AG BW.png', 4);
INSERT INTO `products` VALUES (35, 'Микроволновая печь Samsung MG23T5018AE/BW', 17999.00, 'Микроволновая печь Samsung MG23T5018AE/BW выполнена в компактном корпусе белого и черного цвета и обеспечивает простое управление прикосновением сенсорных кнопок. Данная модель характеризуется внутренним объемом 23 л. Биокерамическое эмалевое покрытие отличается стойкостью к повреждениям и простой очисткой от загрязнений.', 'img/products/Микроволновки/Микроволновая печь Samsung MG23T5018AE BW.png', 4);
INSERT INTO `products` VALUES (36, 'Микроволновая печь Samsung MS23T5018AK/BW', 17590.00, 'Микроволновая печь Samsung MS23T5018AK/BW с классической черной расцветкой корпуса станет главным украшением любой кухни. Хорошая вместительность устройства подтверждается большим объемом рабочей камеры, равным 23 литрам. Вы сможете разогревать большие порции пищи, размещенные на тарелках большого диаметра. Быстрый и равномерный разогрев блюд гарантирует высокая мощность микроволн (800 Вт) и поворотный стол. Изнутри камера прибора покрыта биокерамической эмалью, благодаря чему с ее очисткой от различных загрязнений у вас не возникнет никаких проблем.', 'img/products/Микроволновки/Микроволновая печь Samsung MS23T5018AK BW.png', 4);
INSERT INTO `products` VALUES (37, 'Микроволновая печь Samsung MG23K3515AS/BW', 16990.00, 'Микроволновая печь Samsung MG23K3515AS серебристого цвета с черной стеклянной дверцей и панелью управления обладает расширенным функционалом. Вы можете использовать ее для разморозки, разогрева готовой еды и приготовления различных блюд. Для этого предусмотрены 20 автоматических программ готовки, чтобы вы смогли выбрать оптимальную для определенных блюд. Быструю скорость приготовления обеспечивает высокая мощность в 800 Вт. При этом микроволны равномерно проникают в структуру продуктов, что позволяет сохранить их вкус.', 'img/products/Микроволновки/Микроволновая печь Samsung MG23K3515AS BW.png', 4);
INSERT INTO `products` VALUES (38, 'Микроволновая печь Samsung MS23F302TAK/BW', 12890.00, 'В нее включено 20 программ автоматического меню. Камера микроволновой печи Samsung MS23F302TAK покрыта биокерамической эмалью, которая значительно облегчает эксплуатацию устройства. Помимо программ, в печи присутствуют такие функции, как \"Быстрая разморозка\", \"Защита от детей\" и \"Устранение запахов\" для более комфортного и безопасного использования модели. Более того, печь позволяет выбрать один из нескольких звуков оповещения об окончании таймера.\r\nМощность микроволнового излучения Samsung MS23F302TAK составляет 800 Вт, при этом микроволновая печь потребляет 1150 Вт от электросети. Диаметр вращающегося поддона – 288 мм. Максимальное время таймера составляет 1 час 39 минут – это позволит вам удивлять своих домочадцев сложными блюдами в свое удовольствие.', 'img/products/Микроволновки/Микроволновая печь Samsung MS23F302TAK BW.png', 4);
INSERT INTO `products` VALUES (39, 'Микроволновая печь Samsung MG23K3575AK/BW', 15499.00, 'Микроволновая печь Samsung MG23K3575AK станет полезным и надежным помощником на вашей кухне. Внутренний объем модели составляет 23 л. Печь оборудована крупным поддоном, диаметр которого равен 28.8 см. Преимуществом устройства является наличие гриля, который может работать совместно с микроволнами. Вам также будут полезны функции автоматического разогрева и автоматической разморозки. Присутствует режим поддержания тепла. Печь оборудована поворотным регулятором и кнопочной панелью управления. Вы сможете по достоинству оценить наличие таймера, который может устанавливаться на время до 99 мин.', 'img/products/Микроволновки/Микроволновая печь Samsung MG23K3575AK BW.png', 4);
INSERT INTO `products` VALUES (40, 'Микроволновая печь DOMFY DSB-MW105', 7990.00, 'Компактная и многофункциональная черная микроволновая печь с грилем DOMFY DSB-MW105 объемом 20 л и мощностью 700 Вт с поворотным столом диаметром 25,5 см станет незаменимым помощником на кухне. Возможность выбора различных режимов работы и установки отсрочки включения позволят успешно применять СВЧ не только для подогрева, но и для приготовления блюд. Микроволновка отлично подойдет как опытным кулинарам, готовящим по своим рецептам, так и тем, кто предпочитает простоту и удобство использования проверенных стандартных алгоритмов.', 'img/products/Микроволновки/Микроволновая печь DOMFY DSB-MW105.png', 4);
INSERT INTO `products` VALUES (41, 'Микроволновая печь ACCESSTYLE MG30D100B', 15330.00, 'Модель с увеличенным объёмом внутренней камеры 30 л имеет 8 автоматических режимов меню и 5 режимов мощностей, поэтому шефом может стать даже тот, кто никогда не сталкивался с готовкой. И, конечно, эти комбинированные режимы сильно ускоряют процесс приготовления. Выбирайте один, жмите кнопку старта и все. Осталось только дождаться, когда можно будет пробовать! Кроме того, в устройстве есть режим размораживания. Так что, если вы забыли достать из морозилки рыбу перед приготовлением, микроволновая печь MG30D100B придет на помощь.', 'img/products/Микроволновки/Микроволновая печь ACCESSTYLE MG30D100B.png', 4);
INSERT INTO `products` VALUES (43, 'Колизеев', 4544.00, 'АААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААААА', 'img/products/Стиральные машины/Колизеев.png', 1);

-- ----------------------------
-- Table structure for products_comments
-- ----------------------------
DROP TABLE IF EXISTS `products_comments`;
CREATE TABLE `products_comments`  (
  `id_product` int NULL DEFAULT NULL,
  `id_comment` int NULL DEFAULT NULL,
  INDEX `products_comments_products`(`id_product` ASC) USING BTREE,
  INDEX `products_comments_comments`(`id_comment` ASC) USING BTREE,
  CONSTRAINT `products_comments_products` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `products_comments_comments` FOREIGN KEY (`id_comment`) REFERENCES `сomments` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products_comments
-- ----------------------------

-- ----------------------------
-- Table structure for products_orders
-- ----------------------------
DROP TABLE IF EXISTS `products_orders`;
CREATE TABLE `products_orders`  (
  `id_product` int NULL DEFAULT NULL,
  `id_order` int NULL DEFAULT NULL,
  `count` int NULL DEFAULT NULL,
  INDEX `id_product`(`id_product` ASC) USING BTREE,
  INDEX `orders_products_orders`(`id_order` ASC) USING BTREE,
  CONSTRAINT `orders_products_orders` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_products_products` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of products_orders
-- ----------------------------
INSERT INTO `products_orders` VALUES (2, 1, 1);
INSERT INTO `products_orders` VALUES (1, 1, 2);
INSERT INTO `products_orders` VALUES (2, 2, 1);
INSERT INTO `products_orders` VALUES (1, 2, 2);
INSERT INTO `products_orders` VALUES (1, 3, 1);
INSERT INTO `products_orders` VALUES (5, 3, 1);
INSERT INTO `products_orders` VALUES (4, 3, 1);
INSERT INTO `products_orders` VALUES (1, 4, 2);
INSERT INTO `products_orders` VALUES (5, 4, 1);
INSERT INTO `products_orders` VALUES (4, 4, 1);
INSERT INTO `products_orders` VALUES (1, 5, 2);
INSERT INTO `products_orders` VALUES (5, 5, 1);
INSERT INTO `products_orders` VALUES (4, 5, 1);
INSERT INTO `products_orders` VALUES (2, 6, 1);
INSERT INTO `products_orders` VALUES (1, 6, 1);
INSERT INTO `products_orders` VALUES (8, 6, 4);
INSERT INTO `products_orders` VALUES (8, 8, 5);
INSERT INTO `products_orders` VALUES (1, 9, 1);
INSERT INTO `products_orders` VALUES (2, 9, 2);
INSERT INTO `products_orders` VALUES (2, 10, 1);
INSERT INTO `products_orders` VALUES (3, 11, 1);
INSERT INTO `products_orders` VALUES (2, 12, 1);
INSERT INTO `products_orders` VALUES (8, 12, 1);
INSERT INTO `products_orders` VALUES (3, 13, 1);
INSERT INTO `products_orders` VALUES (2, 13, 1);
INSERT INTO `products_orders` VALUES (2, 14, 2);
INSERT INTO `products_orders` VALUES (1, 16, 2);
INSERT INTO `products_orders` VALUES (2, 16, 2);
INSERT INTO `products_orders` VALUES (6, 16, 1);
INSERT INTO `products_orders` VALUES (3, 17, 1);
INSERT INTO `products_orders` VALUES (15, 20, 2);
INSERT INTO `products_orders` VALUES (30, 21, 1);
INSERT INTO `products_orders` VALUES (30, 22, 1);

-- ----------------------------
-- Table structure for products_stats
-- ----------------------------
DROP TABLE IF EXISTS `products_stats`;
CREATE TABLE `products_stats`  (
  `id_product` int NULL DEFAULT NULL,
  `id_stat` int NULL DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  INDEX `products_stats_stats`(`id_stat` ASC) USING BTREE,
  INDEX `products_stats_products`(`id_product` ASC) USING BTREE,
  CONSTRAINT `products_stats_products` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `products_stats_stats` FOREIGN KEY (`id_stat`) REFERENCES `stats` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products_stats
-- ----------------------------
INSERT INTO `products_stats` VALUES (1, 1, '6');
INSERT INTO `products_stats` VALUES (1, 2, '10');
INSERT INTO `products_stats` VALUES (1, 3, '1000');
INSERT INTO `products_stats` VALUES (1, 4, '72');
INSERT INTO `products_stats` VALUES (1, 5, '60x45x85');
INSERT INTO `products_stats` VALUES (1, 6, '40');
INSERT INTO `products_stats` VALUES (2, 1, '7');
INSERT INTO `products_stats` VALUES (2, 2, '16');
INSERT INTO `products_stats` VALUES (2, 3, '1200');
INSERT INTO `products_stats` VALUES (2, 4, '65');
INSERT INTO `products_stats` VALUES (2, 5, '60x60x85');
INSERT INTO `products_stats` VALUES (2, 6, '45');
INSERT INTO `products_stats` VALUES (6, 7, '2200');
INSERT INTO `products_stats` VALUES (6, 8, '200');
INSERT INTO `products_stats` VALUES (6, 9, '1.2');
INSERT INTO `products_stats` VALUES (6, 10, '1.8');
INSERT INTO `products_stats` VALUES (6, 11, 'Керамическая');
INSERT INTO `products_stats` VALUES (12, 12, '588');
INSERT INTO `products_stats` VALUES (12, 13, '380');
INSERT INTO `products_stats` VALUES (12, 14, '208');
INSERT INTO `products_stats` VALUES (12, 15, 'A++');
INSERT INTO `products_stats` VALUES (12, 16, '38');
INSERT INTO `products_stats` VALUES (12, 17, '90x75x180');
INSERT INTO `products_stats` VALUES (30, 18, '20');
INSERT INTO `products_stats` VALUES (30, 19, '700');
INSERT INTO `products_stats` VALUES (30, 20, '25.5');
INSERT INTO `products_stats` VALUES (30, 21, '5');
INSERT INTO `products_stats` VALUES (30, 22, '45x35x25');
INSERT INTO `products_stats` VALUES (30, 23, 'Механическое');
INSERT INTO `products_stats` VALUES (31, 18, '28');
INSERT INTO `products_stats` VALUES (31, 19, '900');
INSERT INTO `products_stats` VALUES (31, 20, '30');
INSERT INTO `products_stats` VALUES (31, 21, '5');
INSERT INTO `products_stats` VALUES (31, 22, '52x35x30');
INSERT INTO `products_stats` VALUES (31, 23, 'Сенсорное');

-- ----------------------------
-- Table structure for products_subcategories
-- ----------------------------
DROP TABLE IF EXISTS `products_subcategories`;
CREATE TABLE `products_subcategories`  (
  `id_product` int NULL DEFAULT NULL,
  `id_subcategory` int NULL DEFAULT NULL,
  INDEX `subcategories`(`id_subcategory` ASC) USING BTREE,
  INDEX `products`(`id_product` ASC) USING BTREE,
  CONSTRAINT `products` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `subcategories` FOREIGN KEY (`id_subcategory`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of products_subcategories
-- ----------------------------
INSERT INTO `products_subcategories` VALUES (1, 1);
INSERT INTO `products_subcategories` VALUES (2, 1);
INSERT INTO `products_subcategories` VALUES (3, 2);
INSERT INTO `products_subcategories` VALUES (4, 2);
INSERT INTO `products_subcategories` VALUES (5, 3);
INSERT INTO `products_subcategories` VALUES (2, 5);
INSERT INTO `products_subcategories` VALUES (6, 9);
INSERT INTO `products_subcategories` VALUES (7, 10);
INSERT INTO `products_subcategories` VALUES (8, 10);
INSERT INTO `products_subcategories` VALUES (9, 11);
INSERT INTO `products_subcategories` VALUES (10, 11);
INSERT INTO `products_subcategories` VALUES (12, 6);
INSERT INTO `products_subcategories` VALUES (12, 12);
INSERT INTO `products_subcategories` VALUES (13, 7);
INSERT INTO `products_subcategories` VALUES (13, 8);
INSERT INTO `products_subcategories` VALUES (14, 7);
INSERT INTO `products_subcategories` VALUES (15, 7);
INSERT INTO `products_subcategories` VALUES (15, 12);
INSERT INTO `products_subcategories` VALUES (30, 13);
INSERT INTO `products_subcategories` VALUES (31, 13);
INSERT INTO `products_subcategories` VALUES (32, 13);
INSERT INTO `products_subcategories` VALUES (33, 13);
INSERT INTO `products_subcategories` VALUES (34, 14);
INSERT INTO `products_subcategories` VALUES (35, 14);
INSERT INTO `products_subcategories` VALUES (36, 14);
INSERT INTO `products_subcategories` VALUES (37, 14);
INSERT INTO `products_subcategories` VALUES (38, 15);
INSERT INTO `products_subcategories` VALUES (39, 15);
INSERT INTO `products_subcategories` VALUES (40, 15);
INSERT INTO `products_subcategories` VALUES (41, 15);
INSERT INTO `products_subcategories` VALUES (43, 1);

-- ----------------------------
-- Table structure for stats
-- ----------------------------
DROP TABLE IF EXISTS `stats`;
CREATE TABLE `stats`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `unit` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `id_category` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `characteristics_categories`(`id_category` ASC) USING BTREE,
  CONSTRAINT `stats_categories` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of stats
-- ----------------------------
INSERT INTO `stats` VALUES (1, 'Загрузка', 'кг', 1);
INSERT INTO `stats` VALUES (2, 'Количество программ', 'шт', 1);
INSERT INTO `stats` VALUES (3, 'Максимальная скорость отжима', 'об/мин', 1);
INSERT INTO `stats` VALUES (4, 'Уровень шума', 'дБ', 1);
INSERT INTO `stats` VALUES (5, 'Габариты (ШxГxВ)', 'см', 1);
INSERT INTO `stats` VALUES (6, 'Вместимость бака', 'л', 1);
INSERT INTO `stats` VALUES (7, 'Общий объем', 'л', 2);
INSERT INTO `stats` VALUES (8, 'Объем холодильной камеры', 'л', 2);
INSERT INTO `stats` VALUES (9, 'Объем морозильной камеры', 'л', 2);
INSERT INTO `stats` VALUES (10, 'Класс энергопотребления', NULL, 2);
INSERT INTO `stats` VALUES (11, 'Уровень шума', 'дБ', 2);
INSERT INTO `stats` VALUES (12, 'Габариты (ШxГxВ)', 'см', 2);
INSERT INTO `stats` VALUES (13, 'Мощность', 'Вт', 3);
INSERT INTO `stats` VALUES (14, 'Объем резервуара для воды', 'мл', 3);
INSERT INTO `stats` VALUES (15, 'Вес', 'кг', 3);
INSERT INTO `stats` VALUES (16, 'Длина шнура', 'м', 3);
INSERT INTO `stats` VALUES (17, 'Тип подошвы', NULL, 3);
INSERT INTO `stats` VALUES (18, 'Объем', 'л', 4);
INSERT INTO `stats` VALUES (19, 'Мощность', 'Вт', 4);
INSERT INTO `stats` VALUES (20, 'Диаметр поддона', 'см', 4);
INSERT INTO `stats` VALUES (21, 'Количество уровней мощности', 'шт', 4);
INSERT INTO `stats` VALUES (22, 'Габариты (ШxГxВ)', 'см', 4);
INSERT INTO `stats` VALUES (23, 'Тип управления', NULL, 4);

-- ----------------------------
-- Table structure for statuses
-- ----------------------------
DROP TABLE IF EXISTS `statuses`;
CREATE TABLE `statuses`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of statuses
-- ----------------------------
INSERT INTO `statuses` VALUES (1, 'В обработке');
INSERT INTO `statuses` VALUES (2, 'Выполнен');
INSERT INTO `statuses` VALUES (3, 'Отменен');
INSERT INTO `statuses` VALUES (4, 'В пути');
INSERT INTO `statuses` VALUES (5, 'Доставлен');
INSERT INTO `statuses` VALUES (6, 'Возвращен');
INSERT INTO `statuses` VALUES (7, 'Отказ');

-- ----------------------------
-- Table structure for subcategories
-- ----------------------------
DROP TABLE IF EXISTS `subcategories`;
CREATE TABLE `subcategories`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `id_category` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `subcategories_categories`(`id_category` ASC) USING BTREE,
  CONSTRAINT `subcategories_categories` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of subcategories
-- ----------------------------
INSERT INTO `subcategories` VALUES (1, 'Полноразмерные стиральные машины', 1);
INSERT INTO `subcategories` VALUES (2, 'Узкие стиральные машины', 1);
INSERT INTO `subcategories` VALUES (3, 'Стиральные машины с вертикальной загрузкой', 1);
INSERT INTO `subcategories` VALUES (5, 'Стиральные машины с сушкой', 1);
INSERT INTO `subcategories` VALUES (6, 'Трёхкамерные холодильники', 2);
INSERT INTO `subcategories` VALUES (7, 'Двухкамерные холодильники', 2);
INSERT INTO `subcategories` VALUES (8, 'No-Frost', 2);
INSERT INTO `subcategories` VALUES (9, 'Беспроводные', 3);
INSERT INTO `subcategories` VALUES (10, 'Дорожные', 3);
INSERT INTO `subcategories` VALUES (11, 'Керамические', 3);
INSERT INTO `subcategories` VALUES (12, 'Side-by-side', 2);
INSERT INTO `subcategories` VALUES (13, 'Белые', 4);
INSERT INTO `subcategories` VALUES (14, 'Керамические', 4);
INSERT INTO `subcategories` VALUES (15, 'Комбинированные', 4);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `is_admin` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `idx_login`(`login` ASC) USING BTREE,
  UNIQUE INDEX `idx_email`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (4, 'tial_nordon', 'tialnordon@gmail.com', '74db120f0a8e5646ef5a30154e9f6deb', 1);
INSERT INTO `users` VALUES (5, 'login', 'testurl@mail.ru', '15de21c670ae7c3f6f3f1f37029303c9', 0);
INSERT INTO `users` VALUES (8, 'lox', 'lox@lox.ru', '54508291c59a2adb825c143f61b32f53', 0);
INSERT INTO `users` VALUES (9, 'ivan', 'ivan@yandex.ru', '2c42e5cf1cdbafea04ed267018ef1511', 0);
INSERT INTO `users` VALUES (10, 'newbie', 'newbie@email.com', '202cb962ac59075b964b07152d234b70', 0);
INSERT INTO `users` VALUES (11, 'you', 'me@gg.org', '698d51a19d8a121ce581499d7b701668', 0);
INSERT INTO `users` VALUES (12, 'admin', 'tial_nordon@gmail.com', '15de21c670ae7c3f6f3f1f37029303c9', 0);
INSERT INTO `users` VALUES (14, 'nig', 'huve@kkk.ru', 'fae0b27c451c728867a567e8c1bb4e53', 0);
INSERT INTO `users` VALUES (15, 'biba', 'boba@aba.ru', '68053af2923e00204c3ca7c6a3150cf7', 0);
INSERT INTO `users` VALUES (16, 'testtest', 'testtest@test.com', '15de21c670ae7c3f6f3f1f37029303c9', 0);

-- ----------------------------
-- Table structure for users_orders
-- ----------------------------
DROP TABLE IF EXISTS `users_orders`;
CREATE TABLE `users_orders`  (
  `id_user` int NULL DEFAULT NULL,
  `id_order` int NULL DEFAULT NULL,
  INDEX `users`(`id_user` ASC) USING BTREE,
  INDEX `orders`(`id_order` ASC) USING BTREE,
  CONSTRAINT `orders` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users_orders
-- ----------------------------
INSERT INTO `users_orders` VALUES (5, 1);
INSERT INTO `users_orders` VALUES (5, 2);
INSERT INTO `users_orders` VALUES (5, 3);
INSERT INTO `users_orders` VALUES (5, 4);
INSERT INTO `users_orders` VALUES (5, 5);
INSERT INTO `users_orders` VALUES (5, 6);
INSERT INTO `users_orders` VALUES (4, 8);
INSERT INTO `users_orders` VALUES (5, 11);
INSERT INTO `users_orders` VALUES (4, 12);
INSERT INTO `users_orders` VALUES (4, 13);
INSERT INTO `users_orders` VALUES (4, 14);
INSERT INTO `users_orders` VALUES (15, 16);
INSERT INTO `users_orders` VALUES (15, 17);
INSERT INTO `users_orders` VALUES (5, 20);
INSERT INTO `users_orders` VALUES (5, 21);
INSERT INTO `users_orders` VALUES (16, 22);

-- ----------------------------
-- Table structure for сomments
-- ----------------------------
DROP TABLE IF EXISTS `сomments`;
CREATE TABLE `сomments`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `star_count` int NULL DEFAULT NULL,
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `comments_users`(`id_user` ASC) USING BTREE,
  CONSTRAINT `comments_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of сomments
-- ----------------------------
INSERT INTO `сomments` VALUES (1, 5, 'вывыв', 4);

-- ----------------------------
-- Function structure for hashing
-- ----------------------------
DROP FUNCTION IF EXISTS `hashing`;
delimiter ;;
CREATE FUNCTION `hashing`(pass VARCHAR(255))
 RETURNS varchar(255) CHARSET utf8mb4
  DETERMINISTIC
BEGIN
  RETURN MD5(pass);
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table users
-- ----------------------------
DROP TRIGGER IF EXISTS `hash_insert`;
delimiter ;;
CREATE TRIGGER `hash_insert` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
   SET NEW.password = hashing(NEW.password);
END
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table users
-- ----------------------------
DROP TRIGGER IF EXISTS `hash_update`;
delimiter ;;
CREATE TRIGGER `hash_update` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
   SET NEW.password = hashing(NEW.password);
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
