-- MySQL dump 10.13  Distrib 8.0.41, for Linux (x86_64)
--
-- Host: localhost    Database: vkurse_db
-- ------------------------------------------------------
-- Server version	8.0.41-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id_comment` int NOT NULL,
  `id_post` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `comment_text` mediumtext,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `id_user` (`id_user`),
  KEY `id_post` (`id_post`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id_post` INT AUTO_INCREMENT PRIMARY KEY,
  `id_user` int DEFAULT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `post_text` mediumtext,
  `departament` json DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `vote_until` datetime DEFAULT NULL,
  `path` varchar(1000) DEFAULT NULL,
  `vote` tinyint(1) DEFAULT NULL,
  `comments` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_post`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
ALTER TABLE posts MODIFY COLUMN id_post INT AUTO_INCREMENT PRIMARY KEY;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (2,'Скидываемся на др Татьяны Анатольевны','Дорогие коллеги!\n\nКак вы знаете, скоро у нас есть прекрасная возможность отпраздновать день рождения Татьяны Анатольевны. Это событие — отличный повод не \nтолько поздравить ее, но и выразить наши искренние благодарности за ту поддержку и руководство, которые она предоставляет нам каждый день.\nТатьяна Анатольевна — это не просто наш руководитель, но и человек, \nкоторый всегда готов прийти на помощь, поддержать инициативы и вдохновить на достижение новых вершин. В своей работе она демонстрирует \nисключительную преданность и профессионализм, и нам важно показать, что мы ценим ее усилия и заботу о нашей команде.\nСкидывание на подарок — это не только традиция, но и знак единства \nнашего коллектива. Мы можем объединиться в этом жесте доброты и уважения, чтобы сделать ее день рождения особенным. Выбор подарка — это \nвозможность проявить креативность и заботу, что только укрепит нашу команду и создаст положительную атмосферу в офисе.\nВместе мы сможем подарить Татьяне Анатольевне что-то, что отражает нашу \nпризнательность и уважение к ней. Давайте покажем, как мы ценим нашего руководителя и сделаем этот день особенным!\nСогласны ли вы скинуться на подарок для Татьяны Анатольевны? Ваше мнение\n и участие очень важны!Дорогие коллеги!\nСегодня мы отмечаем один из самых трогательных и значимых праздников — День матери. В этот особенный день хочу от всей души поздравить вас, наших замечательных сотрудниц, с этим важным праздником!\nМатеринство — это величайший дар, наполненный бесконечной любовью, заботой и терпением. Вы ежедневно придаете вдохновение и теплоту не только своим детям, но и всем нам. Ваша способность сочетать профессиональную деятельность с размышлениями о будущем ваших детей восхищает и вдохновляет.\n\nПусть этот день станет для вас напоминанием о том, как много вы значите для своих близких и для нашей команды. Желаем вам здоровья, счастья и гармонии, а также много радости от того, что вы — мамы, воспитывающие новое поколение, полное мечт и надежд.\n\nС любовью и уважением,  \n\nВаши QA\nУважаемые коллеги!\nСообщаем вам, что в связи с плановыми работами на электросетях с [указать дату и время начала] по [указать дату и время окончания] будет временно отключено электричество в нашем офисе.\nВ это время мы рекомендуем вам учесть следующие рекомендации:\nЗаранее сохраните важные данные. Убедитесь, что все ваши работы сохранены и, при необходимости, сделайте резервные копии важных файлов, чтобы избежать потери информации.\nПланируйте рабочие часы. Рассмотрите возможность работы из дома или переноса задач, которые требуют электричества, на другое время.\nИспользуйте альтернативные решения. Если у вас есть доступ к аккумуляторам, мобильным устройствам или другим источникам питания, подготовьте их заранее.\nОбсуждайте свои планы. Если у вас есть вопросы или вам нужна помощь в организации работы во время отключения, пожалуйста, не стесняйтесь обратиться к коллегам или руководству.\n\nБлагодарим вас за понимание и терпение в этот период. Работаем над тем, чтобы минимизировать возможные неудобства.\nС уважением,  \nВаши QA ','[\"QA\"]','2024-10-13 00:00:00',NULL,NULL,1,0),(2,'Скидываемся на др Татьяны \nАнатольевны','Дорогие коллеги!\nКак вы знаете, скоро у нас есть прекрасная возможность отпраздновать \nдень рождения Татьяны Анатольевны. Это событие — отличный повод не только поздравить ее, но и выразить наши искренние благодарности за ту \nподдержку и руководство, которые она предоставляет нам каждый день.Татьяна Анатольевна — это не просто наш руководитель, но и человек, \nкоторый всегда готов прийти на помощь, поддержать инициативы и вдохновить на достижение новых вершин. В своей работе она демонстрирует \nисключительную преданность и профессионализм, и нам важно показать, что мы ценим ее усилия и заботу о нашей команде.\nСкидывание на подарок — это не только традиция, но и знак единства \nнашего коллектива. Мы можем объединиться в этом жесте доброты и уважения, чтобы сделать ее день рождения особенным. Выбор подарка — это \nвозможность проявить креативность и заботу, что только укрепит нашу команду и создаст положительную атмосферу в офисе.\nВместе мы сможем подарить Татьяне Анатольевне что-то, что отражает нашу \nпризнательность и уважение к ней. Давайте покажем, как мы ценим нашего руководителя и сделаем этот день особенным!\nСогласны ли вы скинуться на подарок для Татьяны Анатольевны? Ваше мнение\n и участие очень важны!Дорогие коллеги!\nСегодня мы отмечаем один из самых трогательных и значимых праздников — День матери. В этот особенный день хочу от всей души поздравить вас, \nнаших замечательных сотрудниц, с этим важным праздником!Материнство — это величайший дар, наполненный бесконечной любовью, \nзаботой и терпением. Вы ежедневно придаете вдохновение и теплоту не только своим детям, но и всем нам. Ваша способность сочетать \nпрофессиональную деятельность с размышлениями о будущем ваших детей восхищает и вдохновляет.\nПусть этот день станет для вас напоминанием о том, как много вы значите \nдля своих близких и для нашей команды. Желаем вам здоровья, счастья и гармонии, а также много радости от того, что вы — мамы, воспитывающие \nновое поколение, полное мечт и надежд.\nС любовью и уважением,  \nВаши QA ','[\"QA\"]','2024-11-24 00:00:00',NULL,NULL,1,0),(1,'Мотивация сотрудников','Когда на горизонте мерцает Новый Год, кажется, будто время останавливается. Праздничная атмосфера наполняет наши сердца теплом, и мы начинаем мечтать о том, что принесет нам грядущий год. Но иногда, в эти моменты радости и ожидания, нас охватывает чувство усталости. Работа становится утомительной, и возникает желание просто отдохнуть. \nНо именно в такие моменты важно помнить, что мечты сбываются только тогда, когда мы усердно трудимся над ними. Каждая мечта — это не просто карта желаемого, это путь, полный препятствий, которые нужно преодолеть. Да, иногда работа может казаться рутинной и неинтересной, но каждое усилие, вложенное в осуществление своей мечты, приближает нас к ней.\nДаже если сейчас хочется просто расслабиться, знай: каждая минута, потраченная на работу, — это инвестиция в твое будущее. Когда всё вокруг наполняется ожиданием праздника, не позволяй себе забывать о своих целях. Каждая мелкая задача, выполненная с энтузиазмом, приближает тебя к реализации твоей мечты. \nПомни, что великие достижения редко приходят к тем, кто сидит сложа руки и ждет, когда они свалятся с небес. Это твоё время, и если ты приложишь усилия сейчас, это станет основой для всего того, что ты хочешь достичь в будущем. \nТак что, когда появится желание оставить всё и отпустить мечты, сделай глубокий вдох и вспомни, во имя чего ты начинаешь каждый день. Работай над своими целями даже в преддверии праздников, и ты увидишь, как твои усилия принесут плоды. Каждый день, даже самый тяжелый, — это шаг к твоей мечте. И пусть Новый Год станет для тебя не только символом перемен, но и временем, когда ты обретешь уверенность в том, что работа над мечтой никогда не бывает напрасной.\nВперед, к новым достижениям! Ваши мечты ждут вас, и они явятся тому, кто готов работать ради их исполнения.\n--- \nДвигайтесь к своей мечте, даже когда это сложно. Ваши усилия окупятся!,  \nВаш любящий админ ','[\"QA\", \"developer\"]','2024-11-24 00:00:00',NULL,'/images/2.jpg',0,1),(3,'С днем матери','Дорогие коллеги!\n\nСегодня мы отмечаем один из самых трогательных и значимых праздников — День матери. В этот особенный день хочу от всей души поздравить вас, \nнаших замечательных сотрудниц, с этим важным праздником!\nМатеринство — это величайший дар, наполненный бесконечной любовью, \nзаботой и терпением. Вы ежедневно придаете вдохновение и теплоту не только своим детям, но и всем нам. Ваша способность сочетать \nпрофессиональную деятельность с размышлениями о будущем ваших детей восхищает и вдохновляет.\nПусть этот день станет для вас напоминанием о том, как много вы значите \nдля своих близких и для нашей команды. Желаем вам здоровья, счастья и гармонии, а также много радости от того, что вы — мамы, воспитывающие \nновое поколение, полное мечт и надежд.\nС любовью и уважением,  \nВаши QA','[\"QA\"]','2024-11-24 00:00:00',NULL,'/images/3.jpg',0,1);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `session` (
  `id` int NOT NULL,
  `cookie` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `session_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` VALUES (1,'d52e2a92ee82617ef7d788c8acfd56ae3b577f985cc568ece5a8eeddc8c844bf'),(2,'edb73718938194945263629525e79b17c23b2b33b271d0e22d3bc37feff50b41'),(3,'bafb7441ca985a9ac39ea971dffe69f0a07dc52b171962b18879440e5d8b1436'),(5,'69ea214d7a873279b43744c05bb47044fe3d30ab6c8df5be34487fc8236385aa');
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `departament` varchar(100) DEFAULT NULL,
  `hire_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Иван','Шнайдер','Григорьевич','admin@yandex.ru','admin','admin','admin','2024-11-23 00:00:00'),(2,'Евгений','Курбатов','Валерьевич','curbatov@yandex.ru','curbatov','editor','QA','2024-11-23 00:00:00'),(3,'Михаил','Греков','Александрович','grekov@yandex.ru','grekov123','editor','developer','2024-11-24 00:00:00'),(4,'Дмитрий','Коньков','Александрович','krasavchic@main.ru','grekov123','editor','developer','2024-11-24 00:00:00'),(5,'Олег','Тарасенко','Тигранович','krasavchic2@main.ru','qwerty123','usual','developer','2024-11-24 00:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `votes` (
  `id_post` int NOT NULL,
  `id_user` int NOT NULL,
  `vote` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_post`,`id_user`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votes`
--

LOCK TABLES `votes` WRITE;
/*!40000 ALTER TABLE `votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `votes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-16 12:52:23
