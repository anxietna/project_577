-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2026 at 09:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smartviddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `feedbackText` text NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedbackID`, `userID`, `feedbackText`, `rating`, `created_at`) VALUES
(1, 1, 'wowww', 4, '2025-11-19 15:17:23'),
(3, 12, 'good', 5, '2026-01-07 16:16:27');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(11) NOT NULL,
  `cardName` varchar(100) NOT NULL,
  `cardNumber` varchar(20) NOT NULL,
  `expDate` varchar(10) NOT NULL,
  `cvv` varchar(5) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `idUser` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `planID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentID`, `cardName`, `cardNumber`, `expDate`, `cvv`, `price`, `idUser`, `created_at`, `planID`) VALUES
(3, 'syafiqah', '2345678908765434', '2025-12', '786', 45.00, 1, '2025-11-19 11:59:05', 2),
(4, 'Iqa Rahim', '1234456789987654', '2026-12', '234', 2.00, 12, '2026-01-06 15:53:24', 1),
(5, 'Syafiqa', '2345678765432345', '2026-12', '123', 45.00, 12, '2026-01-07 08:17:33', 2),
(6, 'iqa', '8765434567890987', '2026-07', '345', 2.00, 12, '2026-01-07 08:46:09', 1),
(7, 'iqa', '3456543456787654', '2026-05', '545', 99.00, 12, '2026-01-07 08:47:06', 3);

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `subscriptionID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `subscription_type` enum('free','daily','monthly','yearly') NOT NULL DEFAULT 'free',
  `start_date` datetime DEFAULT current_timestamp(),
  `end_date` datetime DEFAULT NULL,
  `usage_count` int(11) DEFAULT 0,
  `max_usage` int(11) DEFAULT 5,
  `status` enum('active','expired') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`subscriptionID`, `userID`, `subscription_type`, `start_date`, `end_date`, `usage_count`, `max_usage`, `status`) VALUES
(1, 1, 'monthly', '2025-11-19 19:59:05', NULL, 0, 999999, 'active'),
(4, 8, 'yearly', '2025-11-19 15:39:13', NULL, 0, 999999, 'active'),
(5, 10, 'free', '2026-01-06 00:00:00', '2026-02-05 00:00:00', 0, 5, 'active'),
(6, 11, 'free', '2026-01-06 00:00:00', '2026-02-05 00:00:00', 0, 5, 'active'),
(7, 12, 'yearly', '2026-01-07 09:47:06', '2027-01-07 09:47:06', 0, 999999, 'active'),
(8, 13, 'free', '2026-01-06 00:00:00', '2026-02-05 00:00:00', 0, 5, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `subsplan`
--

CREATE TABLE `subsplan` (
  `planID` int(11) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subsplan`
--

INSERT INTO `subsplan` (`planID`, `plan_name`, `price`, `description`) VALUES
(1, 'Daily', 2.00, 'Access all features for 24 hours....'),
(2, 'Monthly', 45.00, 'Unlimited summarization for 30 days.'),
(3, 'Yearly', 99.00, 'Best value! Unlimited access for 12 months.');

-- --------------------------------------------------------

--
-- Table structure for table `summaries`
--

CREATE TABLE `summaries` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `summary_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `subject` varchar(255) DEFAULT NULL,
  `video_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `summaries`
--

INSERT INTO `summaries` (`id`, `idUser`, `summary_text`, `created_at`, `subject`, `video_url`) VALUES
(1, 1, 'This TED Talk by **Clint Smith** explores the **profound impact of silence** and the **critical importance of speaking up** against injustice and ignorance.\n\n## Introduction: The Power of Silence\n\n*   Smith begins by quoting **Dr. Martin Luther King Jr.**, who stated, \"In the end, we will remember not the words of our enemies, but the **silence of our friends**.\"\n*   As a teacher, Smith has **internalized this message**, recognizing the **consequences of silence** in various forms: **discrimination, violence, genocide, and war**.\n\n## Cultivating Voice in the Classroom\n\n*   Smith challenges his students to explore their own **silences** through poetry, aiming to help them **recognize, name, and understand** these unspoken aspects of their lives, not as sources of shame.\n*   His classroom operates on **four core principles**:\n    *   Read critically\n    *   Write consciously\n    *   Speak clearly\n    *   **Tell your truth**\n\n## Personal Journey: Confronting His Own Silence\n\n*   Smith reflects on the last principle, \"**Tell your truth**,\" realizing that to ask his students to speak up, he must also share his own experiences of silence.\n*   He recounts his Catholic upbringing in New Orleans, where during Lent, he was taught to **\"give something up\"** as a sacrifice. He gave up various indulgences over the years.\n*   One year, he **gave up speaking**, believing it to be the most valuable sacrifice. However, he realized he had **\"given that up a long time ago.\"**\n*   He admits to spending much of his life telling people what they *wanted* to hear, not what they *needed* to hear, and convincing himself he wasn\'t meant to be anyone\'s conscience. This led him to **\"just wouldn\'t say anything,\" appeasing ignorance with his silence.**\n\n## The Manifestations of Silence: Personal Anecdotes\n\nSmith shares three powerful personal anecdotes illustrating his past **failures to speak up**:\n\n*   **Christian\'s Beating**: When a gay friend, Christian, was beaten, Smith **\"put my hands in my pocket and walked with my head down as if I didn\'t even notice.\"** He later couldn\'t use his locker because the bolt reminded him of the **\"one I had put on my lips.\"**\n*   **The Homeless Man**: He ignored a homeless man seeking affirmation, more concerned with his phone than acknowledging the man\'s humanity.\n*   **The Fundraiser**: At a fundraising gala, a woman made a condescending remark about his \"poor, unintelligent kids.\" Smith **\"bit my lip because apparently we needed her money more than my students needed their dignity.\"**\n\n## The Nature of Silence and a Call to Action\n\n*   Smith asserts that **silence is the residue of fear**. It is:\n    *   \"Filling your flaws\"\n    *   \"Gut-wrench guillotine your tongue\"\n    *   \"The air retreating from your chest because it doesn\'t feel safe in your lungs\"\n    *   **Rwanda, genocide, Katrina, the sound after the noose is tied, charring, chains, privilege, pain.**\n*   He emphasizes that there\'s **\"no time to pick your battles when your battles have already picked you.\"**\n*   He vows to **no longer let silence \"wrap itself around my indecision.\"**\n*   He commits to actively speaking his truth:\n    *   He will tell Christian he is a **\"lion, a sanctuary of bravery and brilliance.\"**\n    *   He will ask the homeless man his name and how his day was, recognizing that **\"sometimes all people want to be is human.\"**\n    *   He will challenge the woman at the fundraiser, affirming his students\' intelligence and capability.\n\n## Conclusion: Unleashing Your Voice\n\n*   Smith concludes with a powerful declaration: **\"This year, instead of giving something up, I will live every day as if there were a microphone tucked under my tongue, a stage on the underside of my inhibition, because who has to have a soapbox when all you\'ve ever needed is your voice.\"**\n*   The **most important takeaway** is the **empowerment found in using one\'s voice** to challenge injustice, affirm humanity, and **break the cycle of silence born from fear.**', '2026-01-05 08:11:30', NULL, NULL),
(2, 1, 'This video is a powerful motivational speech delivered by **Steve Jobs** at the **Stanford University Commencement in 2005**. He shares three personal stories from his life, offering profound insights on **connecting the dots**, **love and loss**, and **death**.\n\n---\n\n## **Steve Jobs\' 2005 Stanford Commencement Speech: Three Stories of Life**\n\n### **1. Connecting the Dots**\n\nJobs begins by recounting his early life and the unconventional path that led him to his eventual success.\n\n*   **Dropping Out of College:**\n    *   Jobs dropped out of **Reed College** after just six months, but stayed as a \"drop-in\" for another 18 months, attending classes that interested him without the pressure of a degree.\n    *   His decision was driven by the high cost of Reed College, which was consuming his **working-class parents\' life savings**, and his inability to see the **value** in the required curriculum or how it would help him figure out his life\'s purpose.\n\n*   **The Calligraphy Class:**\n    *   During his time as a drop-in, he took a **calligraphy class**, which offered the **best calligraphy instruction in the country**. He learned about **serif and sans-serif typefaces**, varying letter spacing, and what makes **great typography great**.\n    *   At the time, this knowledge seemed to have **no practical application** in his life.\n\n*   **The Macintosh Connection:**\n    *   Ten years later, when designing the **first Macintosh computer**, Jobs remembered his calligraphy lessons. He and his team incorporated **beautiful typography**, including multiple typefaces and proportionally spaced fonts, into the Mac.\n    *   This made the Macintosh the **first computer with beautiful typography**, an innovation later copied by Windows, thus influencing personal computing globally.\n\n*   **Main Takeaway: Trust the Process:**\n    *   Jobs emphasizes that you **cannot connect the dots looking forward**; you can only connect them looking backward.\n    *   The crucial message is to **trust that the dots will somehow connect in your future**. This requires **trusting in something** – your gut, destiny, life, karma, whatever. This belief gives you the confidence to follow your heart, even when it leads you off the well-worn path.\n\n### **2. Love & Loss**\n\nJobs shares his journey with Apple, highlighting the importance of passion and resilience through adversity.\n\n*   **Finding His Passion:**\n    *   He was **lucky** to find what he **loved to do early in life**. At 20, he and **Steve Wozniak** started **Apple** in his parents\' garage.\n    *   In ten years, Apple grew into a **$2 billion company** with over 4,000 employees.\n\n*   **The Firing from Apple:**\n    *   At 30, Jobs was **fired from Apple**. This happened after he hired a talented individual to run the company, but their **visions for the future diverged**, and the board sided with the new CEO.\n    *   He describes this as a **devastating public failure**, leading him to consider leaving Silicon Valley.\n\n*   **Rebirth and New Beginnings:**\n    *   Despite the rejection, he realized he **still loved what he did**. The **heaviness of being successful** was replaced by the **lightness of being a beginner again**, less sure about everything, which freed him.\n    *   This period led him to start two new companies: **NeXT** and **Pixar**.\n    *   He also **fell in love** with an amazing woman who would become his wife.\n    *   **Pixar** went on to create the world\'s first computer-animated feature film, **Toy Story**, and became the most successful animation studio globally.\n    *   In a remarkable turn of events, **Apple bought NeXT**, and Jobs returned to Apple. The technology developed at NeXT became the **heart of Apple\'s current renaissance**.\n\n*   **Main Takeaway: Love What You Do:**\n    *   Jobs believes that getting fired from Apple was the **best thing that could have ever happened to him**.\n    *   He stresses that **your work is going to fill a large part of your life**, and the only way to be truly satisfied is to **do what you believe is great work**.\n    *   The only way to do great work is to **love what you do**. If you haven\'t found it yet, **keep looking and don\'t settle**. Like any great relationship, it gets better with time.\n\n### **3. Death**\n\nJobs concludes with a powerful reflection on mortality and its role in shaping life choices.\n\n*   **Mortality as a Guide:**\n    *   At 17, he read a quote: \"**If you live each day as if it was your last, someday you\'ll most certainly be right.**\" This made a profound impression on him.\n    *   For 33 years, he looked in the mirror every morning and asked himself: \"**If today were the last day of my life, would I want to do what I am about to do today?**\" If the answer was \"No\" for too many consecutive days, he knew he needed to **change something**.\n\n*   **Overcoming Fear:**\n    *   Remembering that you will **be dead soon** is the **most important tool** he ever encountered to help make big choices in life.\n    *   It helps to **avoid the trap of thinking you have something to lose**. He states, \"**You are already naked.**\"\n\n*   **Following Your Heart:**\n    *   There is **no reason not to follow your heart**.\n    *   No one wants to die, but **death is the destination we all share**. No one has ever escaped it.\n    *   Death is likely the **single best invention of Life**; it is **Life\'s change agent**, clearing out the old to make way for the new.\n\n*   **Final Call to Action:**\n    *   **Your time is limited**, so **don\'t waste it living someone else\'s life**.\n    *   **Don\'t be trapped by dogma** (living with the results of other people\'s thinking).\n    *   **Don\'t let the noise of others\' opinions drown out your own inner voice**.\n    *   Most importantly, have the **courage to follow your heart and intuition**. They somehow already know what you truly want to become. **Everything else is secondary**.\n\n*   **Closing Slogan:**\n    *   **Stay Hungry. Stay Foolish.**\n\n---', '2026-01-05 08:20:39', 'Social', 'https://youtu.be/Tuw8hxrFBH8?si=LiWn06OsP1FqFI8C'),
(3, 8, 'This TED Talk by Clint Smith, titled \"The Danger of Silence,\" is a powerful and moving spoken word performance that emphasizes the **importance of speaking up** against injustice and the **perilous consequences of remaining silent**.\n\n---\n\n## Summary of \"The Danger of Silence\" by Clint Smith\n\n### I. Introduction: The Weight of Silence\n\n*   Clint Smith begins by quoting **Dr. Martin Luther King Jr.**, who stated, \"In the end, we will remember not the words of our enemies, but the **silence of our friends**.\"\n*   Smith, as a teacher, has deeply internalized this message, recognizing that **silence** manifests as **discrimination, violence, genocide, and war** in the world around us.\n\n### II. Classroom Philosophy: Finding and Filling Silences\n\n*   In his classroom, Smith challenges his students to **explore the \"silences\" in their own lives through poetry**.\n*   The goal is to **fill those spaces**, **recognize them**, **name them**, and understand that they are **not sources of shame**.\n*   He has **four core principles** posted in his classroom that every student signs:\n    1.  **Read critically.**\n    2.  **Write consciously.**\n    3.  **Speak clearly.**\n    4.  **Tell your truth.**\n\n### III. Personal Confession: The Failure to Speak Up\n\n*   Smith focuses on the last principle, **\"Tell your truth,\"** realizing that to ask his students to speak up, he must first be honest about his own failures.\n*   He shares a personal anecdote from his Catholic upbringing in New Orleans, where during Lent, people would **\"give something up\"** as a sacrifice. He gave up soda, McDonald\'s, French fries, and French kisses.\n*   One year, he **gave up speaking**, only to realize that he had **\"given that up a long time ago.\"**\n*   He recounts instances where his **silence** allowed injustice or ignorance to persist:\n    *   He spent much of his life telling people what they *wanted* to hear, not what they *needed* to.\n    *   He avoided being \"anyone\'s conscience.\"\n    *   When his friend **Christian was beaten for being gay**, Smith **walked with his head down**, pretending not to notice, effectively putting a \"bolt on his lips.\"\n    *   He ignored a **homeless man** on the street, more concerned with his phone than with acknowledging the man\'s humanity.\n    *   At a fundraising gala, he **bit his lip** when a woman made a derogatory comment about his \"poor, unintelligent kids,\" because the school needed her money more than his students needed their **dignity**.\n\n### IV. The Nature of Silence: A Residue of Fear\n\n*   Smith powerfully defines **silence** as the **\"residue of fear.\"**\n*   He describes it as:\n    *   \"Filling your flaws.\"\n    *   \"Gut-wrench guillotine your tongue.\"\n    *   \"The air retreating from your chest because it doesn\'t feel safe in your lungs.\"\n    *   **\"Rewinding genocide.\"**\n    *   **\"Katrina\"** (a reference to the devastating hurricane and its aftermath in his hometown, highlighting systemic neglect).\n    *   \"What you hear when there aren\'t enough body bags left.\"\n    *   \"The sound after the noose is already tied.\"\n    *   \"Charring, chains, privilege, pain.\"\n*   He asserts that **\"there is no time to pick your battles when your battles have already picked you.\"**\n\n### V. Call to Action: Embracing Your Voice\n\n*   Smith concludes with a resolute commitment: **\"I will not let silence wrap itself around my indecision.\"**\n*   He vows to:\n    *   Tell Christian that he is a **lion**, a **sanctuary of bravery and brilliance**.\n    *   Ask the homeless man his name and how his day was, because sometimes all people want to be is **human**.\n    *   Tell the woman at the fundraiser that his students are intelligent and capable.\n*   He declares that this year, instead of giving something up, he will **\"live every day as if there were a microphone tucked under my tongue, a stage on the underside of my inhibition.\"**\n*   The ultimate **most important takeaway** is that **\"all you\'ve ever needed is your voice.\"**', '2026-01-06 00:56:17', 'mathematics', 'https://youtu.be/NiKtZgImdlY?si=HQKtyxXzohifEhH8'),
(4, 12, 'Example summary', '2026-01-07 08:24:12', 'Example Subject', 'https://youtu.be/NiKtZgImdlY?si=HQKtyxXzohifEhH8'),
(5, 12, 'Example summary', '2026-01-07 08:30:28', 'Example Subject', 'https://youtu.be/Tuw8hxrFBH8?si=LiWn06OsP1FqFI8C'),
(6, 12, 'This TED Talk by Clint Smith, titled \"The Danger of Silence,\" explores the profound impact of **silence** and the **importance of speaking up** against injustice.\n\n## Introduction\n\nClint Smith begins by quoting **Dr. Martin Luther King Jr.**, who stated, \"In the end, we will remember not the words of our enemies, but the **silence of our friends**.\" This quote serves as the **central theme** and a powerful call to action, highlighting the **consequences of inaction** in the face of discrimination, violence, genocide, and war.\n\n## Classroom Philosophy: Exploring Silences\n\nAs a teacher, Smith challenges his students to explore the **\"silences\" in their own lives** through **poetry**. He aims to create a classroom culture where students feel safe sharing their intimate silences, recognizing and naming them without shame. His classroom operates on **four core principles**:\n*   Read critically\n*   Write consciously\n*   Speak clearly\n*   **Tell your truth**\n\nSmith emphasizes the last principle, **\"tell your truth,\"** as particularly significant, realizing he must also apply it to himself.\n\n## Personal Reflection and Confession of Silence\n\nSmith shares his **personal journey of realizing his own complicity in silence**. He recounts a childhood tradition of **giving something up for Lent**, and one year, he chose to **give up speaking**. He later realized he had metaphorically \"given up\" his voice long before, by **telling people what they wanted to hear** instead of what they needed to. He illustrates this with three poignant examples:\n\n*   **Witnessing a friend, Christian, being beaten for being gay**, and **walking away in silence**, putting his hands in his pockets and head down.\n*   Ignoring a **homeless man** on the street, prioritizing his phone over acknowledging the man\'s humanity and worth.\n*   Remaining silent when a woman at a fundraising gala made **prejudiced remarks about his students**, valuing the potential donation over his students\' **dignity**.\n\n## The Nature of Silence\n\nSmith powerfully defines **silence** through a series of vivid metaphors:\n*   It is the **\"residue of fear.\"**\n*   It is a **\"gut-wrench guillotine\"** that severs one\'s tongue.\n*   It is the **\"air retreating from your chest\"** because it doesn\'t feel safe in your lungs.\n*   It is **\"rewound genocide.\"**\n*   It is **\"Katrina.\"**\n*   It is the **\"sound after the noose is already tied.\"**\n*   It is **\"chains,\" \"privilege,\"** and **\"pain.\"**\n\n## Call to Action and Commitment\n\nSmith asserts that **\"there is no time to pick your battles when your battles have already picked you.\"** He declares his commitment to **no longer let silence dictate his actions**. He vows to:\n\n*   Affirm **Christian\'s strength and bravery**, calling him a \"lion\" and a \"sanctuary of bravery and brilliance.\"\n*   Acknowledge the **homeless man\'s humanity** by asking his name and how his day was.\n*   Defend his **students\' intelligence and worth**, challenging the prejudiced woman\'s assumptions.\n\nHe concludes with the powerful message that instead of giving something up, he will live every day as if there were a microphone under his tongue, a stage under his inhibitions, because **\"all you\'ve ever needed is your voice.\"**', '2026-01-07 08:41:28', 'art', 'https://youtu.be/NiKtZgImdlY?si=HQKtyxXzohifEhH8');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `name`, `email`, `username`, `password`) VALUES
(1, 'Sya ', 'sya.ahmad@example.com', 'sya', '123'),
(8, 'amni', 'amni@gmail.com', 'amni', 'qwe'),
(10, 'Adriana Riduan', 'sya@gmail.com', 'ru', '678'),
(11, 'Mali', 'malik@gmail.com', 'mal', '789'),
(12, 'iqa', 'iqa@gmail.com', 'iqa', '234'),
(13, 'Hani', 'hani@gmail.com', 'hani', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackID`),
  ADD KEY `fk_feedback_user` (`userID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `fk_plan` (`planID`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`subscriptionID`),
  ADD KEY `fk_subscription_user` (`userID`);

--
-- Indexes for table `subsplan`
--
ALTER TABLE `subsplan`
  ADD PRIMARY KEY (`planID`);

--
-- Indexes for table `summaries`
--
ALTER TABLE `summaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_summary` (`idUser`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `subscriptionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subsplan`
--
ALTER TABLE `subsplan`
  MODIFY `planID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `summaries`
--
ALTER TABLE `summaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_user` FOREIGN KEY (`userID`) REFERENCES `user` (`idUser`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_plan` FOREIGN KEY (`planID`) REFERENCES `subsplan` (`planID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);

--
-- Constraints for table `subscription`
--
ALTER TABLE `subscription`
  ADD CONSTRAINT `fk_subscription_user` FOREIGN KEY (`userID`) REFERENCES `user` (`idUser`) ON DELETE CASCADE;

--
-- Constraints for table `summaries`
--
ALTER TABLE `summaries`
  ADD CONSTRAINT `fk_user_summary` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
