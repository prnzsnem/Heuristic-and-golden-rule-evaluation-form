-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2020 at 09:14 AM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myprojecthci`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `ID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(1000) NOT NULL,
  `user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`ID`, `title`, `url`, `user`) VALUES
(1, 'NepZar.com', 'www.nepzar.com', 'Prince Sanem');

-- --------------------------------------------------------

--
-- Table structure for table `evaluationdata`
--

CREATE TABLE `evaluationdata` (
  `ID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(1000) NOT NULL,
  `user` varchar(100) NOT NULL,
  `qa` varchar(100) NOT NULL,
  `ra` varchar(100) NOT NULL,
  `ma` varchar(100) NOT NULL,
  `qb` varchar(100) NOT NULL,
  `rb` varchar(100) NOT NULL,
  `mb` varchar(100) NOT NULL,
  `qc` varchar(100) NOT NULL,
  `rc` varchar(100) NOT NULL,
  `mc` varchar(100) NOT NULL,
  `qd` varchar(100) NOT NULL,
  `rd` varchar(100) NOT NULL,
  `md` varchar(100) NOT NULL,
  `qe` varchar(100) NOT NULL,
  `re` varchar(100) NOT NULL,
  `me` varchar(100) NOT NULL,
  `qf` varchar(100) NOT NULL,
  `rf` varchar(100) NOT NULL,
  `mf` varchar(100) NOT NULL,
  `qg` varchar(100) NOT NULL,
  `rg` varchar(100) NOT NULL,
  `mg` varchar(100) NOT NULL,
  `qh` varchar(100) NOT NULL,
  `rh` varchar(100) NOT NULL,
  `mh` varchar(100) NOT NULL,
  `qi` varchar(100) NOT NULL,
  `ri` varchar(100) NOT NULL,
  `mi` varchar(100) NOT NULL,
  `qj` varchar(100) NOT NULL,
  `rj` varchar(100) NOT NULL,
  `mj` varchar(100) NOT NULL,
  `qk` varchar(100) NOT NULL,
  `rk` varchar(100) NOT NULL,
  `mk` varchar(100) NOT NULL,
  `ql` varchar(100) NOT NULL,
  `rl` varchar(100) NOT NULL,
  `ml` varchar(100) NOT NULL,
  `qm` varchar(100) NOT NULL,
  `rm` varchar(100) NOT NULL,
  `mm` varchar(100) NOT NULL,
  `qn` varchar(100) NOT NULL,
  `rn` varchar(100) NOT NULL,
  `mn` varchar(100) NOT NULL,
  `qo` varchar(100) NOT NULL,
  `ro` varchar(100) NOT NULL,
  `mo` varchar(100) NOT NULL,
  `qp` varchar(100) NOT NULL,
  `rp` varchar(100) NOT NULL,
  `mp` varchar(100) NOT NULL,
  `qq` varchar(100) NOT NULL,
  `rq` varchar(100) NOT NULL,
  `mq` varchar(100) NOT NULL,
  `qr` varchar(100) NOT NULL,
  `rr` varchar(100) NOT NULL,
  `mr` varchar(100) NOT NULL,
  `qs` varchar(100) NOT NULL,
  `rs` varchar(100) NOT NULL,
  `ms` varchar(100) NOT NULL,
  `qt` varchar(100) NOT NULL,
  `rt` varchar(100) NOT NULL,
  `mt` varchar(100) NOT NULL,
  `messg` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `evaluationdata`
--

INSERT INTO `evaluationdata` (`ID`, `title`, `url`, `user`, `qa`, `ra`, `ma`, `qb`, `rb`, `mb`, `qc`, `rc`, `mc`, `qd`, `rd`, `md`, `qe`, `re`, `me`, `qf`, `rf`, `mf`, `qg`, `rg`, `mg`, `qh`, `rh`, `mh`, `qi`, `ri`, `mi`, `qj`, `rj`, `mj`, `qk`, `rk`, `mk`, `ql`, `rl`, `ml`, `qm`, `rm`, `mm`, `qn`, `rn`, `mn`, `qo`, `ro`, `mo`, `qp`, `rp`, `mp`, `qq`, `rq`, `mq`, `qr`, `rr`, `mr`, `qs`, `rs`, `ms`, `qt`, `rt`, `mt`, `messg`) VALUES
(1, 'NepZar.com', 'www.nepzar.com', 'Prince Sanem', 'Yes', '5', 'Excellent No Need to change', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '3', 'Good But still needs some changes', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '3', 'Good But still needs some changes', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '3', 'Good But still needs some changes', 'Yes', '3', 'Good But still needs some changes', 'Yes', '5', 'Excellent No Need to change', 'Yes', '5', 'Excellent No Need to change', 'Yes', '3', 'Good But still needs some changes', 'Yes', '3', 'Good But still needs some changes', 'Yes', '3', 'Good But still needs some changes', 'Yes', '3', 'Good But still needs some changes', 'Yes', '5', 'Excellent No Need to change', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '3', 'Good But still needs some changes', 'Overall everything is fine');

-- --------------------------------------------------------

--
-- Table structure for table `golden`
--

CREATE TABLE `golden` (
  `ID` int(11) NOT NULL,
  `qa` varchar(100) NOT NULL,
  `ra` varchar(100) NOT NULL,
  `ma` varchar(100) NOT NULL,
  `qb` varchar(100) NOT NULL,
  `rb` varchar(100) NOT NULL,
  `mb` varchar(100) NOT NULL,
  `qc` varchar(100) NOT NULL,
  `rc` varchar(100) NOT NULL,
  `mc` varchar(100) NOT NULL,
  `qd` varchar(100) NOT NULL,
  `rd` varchar(100) NOT NULL,
  `md` varchar(100) NOT NULL,
  `qe` varchar(100) NOT NULL,
  `re` varchar(100) NOT NULL,
  `me` varchar(100) NOT NULL,
  `qf` varchar(100) NOT NULL,
  `rf` varchar(100) NOT NULL,
  `mf` varchar(100) NOT NULL,
  `qg` varchar(100) NOT NULL,
  `rg` varchar(100) NOT NULL,
  `mg` varchar(100) NOT NULL,
  `qh` varchar(100) NOT NULL,
  `rh` varchar(100) NOT NULL,
  `mh` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `golden`
--

INSERT INTO `golden` (`ID`, `qa`, `ra`, `ma`, `qb`, `rb`, `mb`, `qc`, `rc`, `mc`, `qd`, `rd`, `md`, `qe`, `re`, `me`, `qf`, `rf`, `mf`, `qg`, `rg`, `mg`, `qh`, `rh`, `mh`) VALUES
(1, 'Yes', '5', 'Excellent No Need to change', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '3', 'Good But still needs some changes', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '3', 'Good But still needs some changes', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '4', 'Best keep on upgrading and updating');

-- --------------------------------------------------------

--
-- Table structure for table `heuristic`
--

CREATE TABLE `heuristic` (
  `ID` int(11) NOT NULL,
  `qa` varchar(100) NOT NULL,
  `ra` varchar(100) NOT NULL,
  `ma` varchar(100) NOT NULL,
  `qb` varchar(100) NOT NULL,
  `rb` varchar(100) NOT NULL,
  `mb` varchar(100) NOT NULL,
  `qc` varchar(100) NOT NULL,
  `rc` varchar(100) NOT NULL,
  `mc` varchar(100) NOT NULL,
  `qd` varchar(100) NOT NULL,
  `rd` varchar(100) NOT NULL,
  `md` varchar(100) NOT NULL,
  `qe` varchar(100) NOT NULL,
  `re` varchar(100) NOT NULL,
  `me` varchar(100) NOT NULL,
  `qf` varchar(100) NOT NULL,
  `rf` varchar(100) NOT NULL,
  `mf` varchar(100) NOT NULL,
  `qg` varchar(100) NOT NULL,
  `rg` varchar(100) NOT NULL,
  `mg` varchar(100) NOT NULL,
  `qh` varchar(100) NOT NULL,
  `rh` varchar(100) NOT NULL,
  `mh` varchar(100) NOT NULL,
  `qi` varchar(100) NOT NULL,
  `ri` varchar(100) NOT NULL,
  `mi` varchar(100) NOT NULL,
  `qj` varchar(100) NOT NULL,
  `rj` varchar(100) NOT NULL,
  `mj` varchar(100) NOT NULL,
  `qk` varchar(100) NOT NULL,
  `rk` varchar(100) NOT NULL,
  `mk` varchar(100) NOT NULL,
  `ql` varchar(100) NOT NULL,
  `rl` varchar(100) NOT NULL,
  `ml` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `heuristic`
--

INSERT INTO `heuristic` (`ID`, `qa`, `ra`, `ma`, `qb`, `rb`, `mb`, `qc`, `rc`, `mc`, `qd`, `rd`, `md`, `qe`, `re`, `me`, `qf`, `rf`, `mf`, `qg`, `rg`, `mg`, `qh`, `rh`, `mh`, `qi`, `ri`, `mi`, `qj`, `rj`, `mj`, `qk`, `rk`, `mk`, `ql`, `rl`, `ml`) VALUES
(1, 'Yes', '5', 'Excellent No Need to change', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '3', 'Good But still needs some changes', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '3', 'Good But still needs some changes', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '4', 'Best keep on upgrading and updating', 'Yes', '3', 'Good But still needs some changes', 'Yes', '3', 'Good But still needs some changes', 'Yes', '5', 'Excellent No Need to change');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `ID` int(11) NOT NULL,
  `Question type` varchar(100) NOT NULL,
  `Question` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`ID`, `Question type`, `Question`) VALUES
(1, 'Heuristic', 'Visibility of the system'),
(2, 'Heuristic', 'Match between the system and realworld'),
(3, 'Heuristic', 'User control and freedom'),
(4, 'Heuristic', 'Consistency and standard'),
(5, 'Heuristic', 'Error prevention'),
(6, 'Heuristic', 'Aesthetic and minimalistic design'),
(7, 'Heuristic', 'Recognization rather than real'),
(8, 'Heuristic', 'Flexibility & efficiency of use'),
(9, 'Heuristic', 'Help users recognize, diagnose and recover from error'),
(10, 'Heuristic', 'Help and documentation'),
(11, 'Heuristic', 'When error occured does it clear all data?'),
(12, 'Heuristic', 'Does it prevent number input for phone?'),
(13, '8 Golden Rules', 'Strive for consistency'),
(14, '8 Golden Rules', 'Enable frequent users to use shortcuts'),
(15, '8 Golden Rules', 'Offer informative feedback'),
(16, '8 Golden Rules', 'Design dialog to yield closure'),
(17, '8 Golden Rules', 'Offer simple error handling'),
(18, '8 Golden Rules', 'Permit easy reversal of actions'),
(19, '8 Golden Rules', 'Support internal locus of control'),
(20, '8 Golden Rules', 'Reduce short-term memory load');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `evaluationdata`
--
ALTER TABLE `evaluationdata`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `golden`
--
ALTER TABLE `golden`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `heuristic`
--
ALTER TABLE `heuristic`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `evaluationdata`
--
ALTER TABLE `evaluationdata`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `golden`
--
ALTER TABLE `golden`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `heuristic`
--
ALTER TABLE `heuristic`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
