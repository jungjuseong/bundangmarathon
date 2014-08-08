-- phpMyAdmin SQL Dump
-- version 2.9.1.1
-- http://www.phpmyadmin.net
-- 
-- 호스트: localhost
-- 처리한 시간: 08-10-09 10:40 
-- 서버 버전: 3.23.58
-- PHP 버전: 4.4.4
-- 
-- 데이터베이스: `gumpu`
-- 

-- --------------------------------------------------------

-- 
-- 테이블 구조 `chuka`
-- 

DROP TABLE IF EXISTS `chuka`;
CREATE TABLE IF NOT EXISTS `chuka` (
  `no` int(11) NOT NULL auto_increment,
  `memo` varchar(30) NOT NULL default '',
  `in_date` date NOT NULL default '0000-00-00',
  `end_date` date NOT NULL default '0000-00-00',
  `userid` varchar(12) NOT NULL default '',
  `name` varchar(14) default NULL,
  PRIMARY KEY  (`no`)
) TYPE=MyISAM AUTO_INCREMENT=298 ;

-- 
-- 테이블의 덤프 데이터 `chuka`
-- 

INSERT INTO `chuka` (`no`, `memo`, `in_date`, `end_date`, `userid`, `name`) VALUES 
(17, '런조이닷컴 10Km 여자부 2위', '2004-11-06', '0000-00-00', 'run4joy', '이금복'),
(16, '런조이닷컴 하프 여자부 3위', '2004-11-06', '0000-00-00', 'run4joy', '손연자'),
(15, '이천 10Km 남자청년부 1위', '2004-11-06', '0000-00-00', 'run4joy', '강호'),
(14, '이천 10Km 여자청년부 1위', '2004-11-06', '0000-00-00', 'run4joy', '이금복'),
(13, '이천 10Km 남자장년부 2위', '2004-11-06', '0000-00-00', 'run4joy', '김연달'),
(12, '이천 10Km 남자장년부 3위', '2004-11-06', '0000-00-00', 'run4joy', '김영헌'),
(11, '이천 10Km 여자장년부 3위', '2004-11-06', '0000-00-00', 'run4joy', '손연자'),
(18, '딸 은혜양 한영외고 합격', '2004-11-09', '2004-11-24', 'run4joy', '조상국'),
(19, '중앙대회에서 Sub-3:30 달성', '2004-11-09', '0000-00-00', 'run4joy', '손연자'),
(20, '중앙대회에서 Sub-3:30 달성', '2004-11-09', '0000-00-00', 'run4joy', '이금복'),
(34, '동아대회 서브쓰리 달성', '2005-03-17', '0000-00-00', 'run4joy', '박용식'),
(32, '3.1절 SAKA 하프 장년부 4위', '2005-03-01', '0000-00-00', 'run4joy', '김용철'),
(33, '3.1절 SAKA 10Km 장년부 1위', '2005-03-01', '0000-00-00', 'run4joy', '강호'),
(26, '성남탄천대회 5km 남자부2위', '2004-11-14', '0000-00-00', 'run4joy', '유성복'),
(27, '성남탄천대회 10km 장년부 1위', '2004-11-14', '0000-00-00', 'run4joy', '강호'),
(28, '레포츠서울2004 풀코스 1위', '2004-12-14', '0000-00-00', 'run4joy', '강호'),
(29, '레포츠서울2004 30km 여자부 2위', '2004-12-14', '0000-00-00', 'run4joy', '손연자'),
(30, '레포츠서울2004 10km 여자부 2위', '2004-12-14', '0000-00-00', 'run4joy', '이금복'),
(31, '한강시민마라톤 10km 2위', '2004-12-19', '0000-00-00', 'run4joy', '김진수'),
(35, '합천 하프 40대 2위(전체 3위)', '2005-04-09', '0000-00-00', 'run4joy', '강호'),
(36, '3박자건강법 책 출판', '2005-04-16', '0000-00-00', 'run4joy', '주승균'),
(45, '경향대회 2:39:05 전체 6위 입상', '2005-04-24', '0000-00-00', 'run4joy', '강호'),
(42, '천안상록대회 10Km 4위 입상', '2005-04-24', '0000-00-00', 'run4joy', '이금복'),
(44, '경향대회 Sub-3(2:59:16) 달성', '2005-04-24', '0000-00-00', 'run4joy', '김용철'),
(43, '천안상록대회 하프 4위 입상', '2005-04-24', '0000-00-00', 'run4joy', '손연자'),
(48, '영월동강마라톤 하프 1위', '2005-05-22', '0000-00-00', 'run4joy', '강호'),
(47, '5월 정회원 등록... (712번)', '2005-05-01', '0000-00-00', 'seosc', '박균철'),
(49, '정회원 등록 ... (713번)', '2005-05-31', '0000-00-00', 'seosc', '장찬호'),
(50, '정회원 등록 ... (714번)', '2005-05-31', '0000-00-00', 'seosc', '김정중'),
(51, '정회원 등록 ... (715번)', '2005-05-31', '0000-00-00', 'seosc', '황규철'),
(52, '양평 남한강 대회 풀 2위 입상', '2005-06-06', '0000-00-00', 'run4joy', '강호'),
(54, '학원개원("청호" 보습논술학원)', '2005-06-08', '0000-00-00', 'seosc', '윤금노'),
(55, '분당닷컴배 우승', '2005-06-13', '0000-00-00', 'run4joy', '김용철'),
(56, '정회원 등록 ... (716번)', '2005-07-03', '0000-00-00', 'seosc', '박정훈'),
(57, '정회원 등록 ... (717번)', '2005-07-03', '0000-00-00', 'seosc', '이경태'),
(58, '정회원 등록 ... (719번)', '2005-08-05', '0000-00-00', 'seosc', '유완기'),
(59, '정회원 등록 ... (718번)', '2005-08-05', '0000-00-00', 'seosc', '조래선'),
(61, '가구점(다모가구) 오픈 8/27', '2005-08-22', '0000-00-00', 'seosc', '오재현'),
(63, '평강한의원 확장 이전', '2005-09-24', '0000-00-00', 'run4joy', '주승균'),
(72, '클럽 최고기록 경신(2:34:04)', '2005-10-24', '0000-00-00', 'run4joy', '정희진'),
(66, '풍기인삼마라톤 5Km 1위', '2005-10-03', '0000-00-00', 'run4joy', '강호'),
(67, '클럽 마라톤 최고기록(2:37:09)', '2005-10-09', '0000-00-00', 'run4joy', '정희진'),
(70, '춘천마라톤 2위 입상', '2005-10-24', '0000-00-00', 'run4joy', '정희진'),
(73, '정회원 등록 ... (720번)', '2005-10-25', '0000-00-00', 'seosc', '강선영'),
(74, '둘째딸 용인외고 합격', '2005-10-29', '0000-00-00', 'run4joy', '정관택'),
(79, '세브란스마라톤 10km 2위 입상', '2005-11-01', '0000-00-00', 'run4joy', '정희진'),
(78, '세브란스마라톤 10Km 4위 입상', '2005-11-01', '0000-00-00', 'run4joy', '이금복'),
(80, '정회원 등록 ... (721번)', '2005-11-03', '0000-00-00', 'seosc', '조성창'),
(83, '풀코스 첫완주 및 서브3 달성', '2005-11-07', '0000-00-00', 'run4joy', '안현민'),
(84, '119마라톤 하프 1위', '2005-11-08', '0000-00-00', 'run4joy', '정희진'),
(85, '현대자동차 이사 승진', '2005-11-20', '0000-00-00', 'run4joy', '정재욱'),
(87, '정보화마을 대회 10Km 2위 입상', '2005-11-20', '0000-00-00', 'run4joy', '정희진'),
(89, '고창고인돌 하프 4위 입상', '2005-11-20', '0000-00-00', 'run4joy', '강호'),
(90, '동아 백제 10Km 3위 입상', '2005-11-20', '0000-00-00', 'run4joy', '이금복'),
(91, '런조이마라톤 10km 3위 입상', '2005-11-21', '0000-00-00', 'run4joy', '손연자'),
(92, '정보화마을 대회 5Km 6위 입상', '2005-11-21', '0000-00-00', 'run4joy', '신의성회장'),
(93, '손기정평화마라톤 하프 1위', '2005-11-27', '0000-00-00', 'run4joy', '정희진'),
(94, '구세군 마라톤 풀코스 1위', '2005-12-04', '0000-00-00', 'run4joy', '강호'),
(95, '정회원 등록 ... (722번)', '2005-12-05', '0000-00-00', 'seosc', '김매자'),
(96, '한마협강변마라톤 하프 3위', '2005-12-06', '0000-00-00', 'run4joy', '손연자'),
(97, '한마협강변마라톤 10km 4위', '2005-12-06', '0000-00-00', 'run4joy', '이금복'),
(99, '4/4분기 클럽 기록회 우승', '2005-12-19', '0000-00-00', 'run4joy', '정희진'),
(100, '클럽 Sub-3상 수상', '2005-12-24', '0000-00-00', 'run4joy', '안현민'),
(101, '클럽 사이버상 수상', '2005-12-24', '0000-00-00', 'run4joy', '주승균'),
(102, '이경태님, 클럽 성실인상 수상', '2005-12-24', '0000-00-00', 'run4joy', '김호년'),
(103, '정희진님, 클럽 공로상 수상', '2005-12-24', '0000-00-00', 'run4joy', '이만영'),
(104, '클럽 최고기록상 수상', '2005-12-24', '0000-00-00', 'run4joy', '강호'),
(105, '고성 대회에서 Sub-3 달성', '2006-01-18', '0000-00-00', 'run4joy', '유성복'),
(106, '고성 대회에서 Sub-3 달성', '2006-01-18', '0000-00-00', 'run4joy', '박균철'),
(107, '고성 대회 풀 장년부 2위 입상', '2006-01-18', '0000-00-00', 'run4joy', '강호'),
(108, '고성 대회 풀 청년부 3위 입상', '2006-01-18', '0000-00-00', 'run4joy', '정희진'),
(109, '클럽 최고 기록 갱신(2:31:54)', '2006-01-18', '0000-00-00', 'run4joy', '정희진'),
(110, '으뜸부동산 개업(용인 동백지구)', '2006-02-04', '0000-00-00', 'run4joy', '정희진'),
(111, '정회원 등록 ... (801번)', '2006-02-04', '0000-00-00', 'seosc', '안현민'),
(112, '런페스티발 15km 5위 입상', '2006-02-13', '0000-00-00', 'run4joy', '손연자'),
(113, '런페스티발 15km 3위 입상', '2006-02-13', '0000-00-00', 'run4joy', '이금복'),
(114, '여주금당초등학교 교장 발령', '2006-02-25', '0000-00-00', 'run4joy', '김경아'),
(115, '정회원 등록 ... (802번)', '2006-03-02', '0000-00-00', 'seosc', '박하명'),
(116, '정회원 등록 ... (803번)', '2006-03-02', '0000-00-00', 'seosc', '이경규'),
(117, '정회원 등록 ... (804번)', '2006-03-02', '0000-00-00', 'seosc', '정희진'),
(118, '후쿠오카마라톤 참가권 획득', '2006-03-06', '0000-00-00', 'run4joy', '강호'),
(122, '서울마라톤 5위 입상', '2006-03-06', '0000-00-00', 'run4joy', '이금복'),
(121, '서울마라톤 연대별 1위 입상', '2006-03-06', '0000-00-00', 'run4joy', '강호'),
(123, '첫 SUB-3달성 2:59:58', '2006-03-13', '0000-00-00', 'dykim', '김영헌'),
(124, '첫 SUB-3달성 2:59:21', '2006-03-13', '0000-00-00', 'dykim', '이희원'),
(120, '서울마라톤 연대별 1위 입상', '2006-03-06', '0000-00-00', 'run4joy', '손연자'),
(126, '정회원 등록 ... (805번)', '2006-03-13', '0000-00-00', 'seosc', '황기성'),
(127, '정회원 등록 ... (806번)', '2006-03-13', '0000-00-00', 'seosc', '김동규'),
(130, '물사랑대회 5위(2:32:23)입상', '2006-03-20', '0000-00-00', 'run4joy', '강호'),
(133, '인천국제마라톤 10km 4위입상', '2006-03-27', '0000-00-00', 'run4joy', '이금복'),
(134, 'LIG화재 마라톤 풀코스 1위 2:33', '2006-04-02', '0000-00-00', 'taekong303', '강호'),
(135, '첫sub-3달성 2:59:58', '2006-04-02', '0000-00-00', 'taekong303', '이만영'),
(136, '고수등극 왕축하!!!', '2006-04-02', '0000-00-00', 'dkkims63', '이만영'),
(137, '인제내린천 하프 청년부 4위입상', '2006-05-14', '0000-00-00', 'run4joy', '강호'),
(138, '인제내린천 하프 5위 입상', '2006-05-14', '0000-00-00', 'run4joy', '손연자'),
(139, '인제내린천 10km 장년부 7위입상', '2006-05-14', '0000-00-00', 'run4joy', '정관택'),
(141, '인제내린천 10km장년부 10위입상', '2006-05-14', '0000-00-00', 'run4joy', '강민헌'),
(142, '인제내린천 10km 3위 입상', '2006-05-14', '0000-00-00', 'run4joy', '이금복'),
(143, '철사랑 대회 하프 5위 입상', '2006-05-21', '0000-00-00', 'run4joy', '강호'),
(144, '철사랑 대회 10km 1위 입상', '2006-05-21', '0000-00-00', 'run4joy', '이금복'),
(145, '정회원 등록 ... (807번)', '2006-06-01', '0000-00-00', 'seosc', '김영헌B'),
(147, '정회원 등록 ... (808번)', '2006-06-02', '0000-00-00', 'seosc', '박희선'),
(148, '용인마라톤 하프2위 입상', '2006-06-03', '0000-00-00', 'taekong303', '안현민'),
(149, '화천비목 풀코스 3위 입상', '2006-06-04', '0000-00-00', 'run4joy', '강호'),
(150, '화천비목 하프 5위 입상', '2006-06-04', '0000-00-00', 'run4joy', '손연자'),
(151, '포천대회5키로 4위입상', '2006-06-07', '0000-00-00', 'sintofood', '박정훈'),
(152, '창립기념일 기록회 우승', '2006-06-13', '0000-00-00', 'run4joy', '안현민'),
(153, '서울하프대회 청년부1위 입상', '2006-06-18', '0000-00-00', 'kpuacmhk', '임성수'),
(154, '회장 취임 축하 드립니다.', '2006-07-04', '0000-00-00', 'run4joy', '권영주'),
(155, '부회장 취임 축하 드립니다.', '2006-07-04', '0000-00-00', 'run4joy', '안경근'),
(156, '부회장 취임을 축하 합니다!!', '2006-07-23', '0000-00-00', 'bluesky', '정재욱'),
(193, '중앙고양일산마라톤 하프1위', '2007-04-02', '0000-00-00', 'run4joy', '정희진'),
(158, '815경축 하프 마라톤 청년부2위', '2006-08-18', '0000-00-00', 'tigerstar', '임성수'),
(161, '따님 수현 안성 5km 2위 입상', '2006-09-03', '0000-00-00', 'run4joy', '박정훈'),
(162, '철원DMZ 10km 1위 입상', '2006-09-10', '0000-00-00', 'run4joy', '강호'),
(163, '철원DMZ 하프 2위 입상', '2006-09-10', '0000-00-00', 'run4joy', '정희진'),
(166, '김제대회 하프코스 2위 입상', '2006-09-17', '0000-00-00', 'run4joy', '손연자'),
(165, '따님 수현 청소년 10K 1위 입상', '2006-09-11', '0000-00-00', 'tigerstar', '박정훈'),
(167, '김제대회 풀코스 2위 입상', '2006-09-17', '0000-00-00', 'run4joy', '강호'),
(168, '원주 횡성 마라톤 풀코스 3위', '2006-09-18', '0000-00-00', 'tigerstar', '정희진'),
(169, '진안홍삼대회10Km 3위입상', '2006-10-02', '0000-00-00', 'kpuacmhk', '안현민'),
(170, 'MBC 한강 하프 3위 입상', '2006-10-23', '0000-00-00', 'tigerstar', '손연자'),
(174, '서울울트라마라톤 63.3km 3위', '2006-11-19', '0000-00-00', 'run4joy', '강호'),
(175, '서울울트라마라톤 63.3km 3위', '2006-11-19', '0000-00-00', 'run4joy', '손연자'),
(176, '스포츠서울대회 첫 Sub-3 달성', '2006-11-19', '0000-00-00', 'run4joy', '박정훈'),
(177, '산타마라톤 5km 1위 입상', '2006-12-16', '0000-00-00', 'mylee8727', '정희진'),
(179, '신임부회장 축하합니다.', '2007-01-14', '0000-00-00', 'marajeon', '배종문'),
(181, '마스터즈 챌린저 마라톤 1위', '2007-02-26', '0000-00-00', 'bluesky', '정희진'),
(182, '마스터즈 챌린저 15km 1위', '2007-02-26', '0000-00-00', 'taekong303', '강호'),
(183, '경기국제마라톤 10km 4위', '2007-02-26', '0000-00-00', 'taekong303', '강호'),
(187, '천안 유관순마라톤 10K 4위 입상', '2007-03-16', '2007-03-16', 'tigerstar', '정희진'),
(189, '인천국제마라톤 풀코스 1위', '2007-03-25', '0000-00-00', 'bluesky', '강호'),
(191, '불암수락산악마라톤 청년부4위', '2007-03-26', '0000-00-00', 'run4joy', '김종철'),
(199, '경기마라톤5Km 2위 입상', '2007-04-22', '0000-00-00', 'kpuacmhk', '손연자'),
(195, '서산하프 장년부 2위', '2007-04-08', '0000-00-00', 'run4joy', '강호'),
(196, '서산하프 청년부 1위', '2007-04-08', '0000-00-00', 'run4joy', '정희진'),
(198, '경향 서울마라톤 풀 2위', '2007-04-16', '0000-00-00', 'run4joy', '강호'),
(204, '철강사랑 마라톤 하프 1위', '2007-05-20', '0000-00-00', 'bluesky', '강호'),
(202, '보성녹차마라톤 하프 2위 입상', '2007-05-07', '0000-00-00', 'run4joy', '강호'),
(209, '양평마라톤 하프 1위', '2007-06-04', '0000-00-00', 'run4joy', '강호'),
(211, '양평마라톤 하프 5위', '2007-06-04', '0000-00-00', 'run4joy', '손연자'),
(210, '양평마라톤 하프 5위', '2007-06-04', '0000-00-00', 'run4joy', '안현민'),
(212, '새벽강변마라톤대회 6위', '2007-07-03', '0000-00-00', 'run4joy', '김종철'),
(213, '새벽강변대회 하프 연대별 1위', '2007-07-06', '0000-00-00', 'run4joy', '정관택'),
(214, '새벽강변대회 풀 연대별 1위', '2007-07-06', '0000-00-00', 'run4joy', '안현민'),
(215, '앙성온천 충주복숭아 하프 4위', '2007-09-03', '0000-00-00', 'run4joy', '강호'),
(216, '사이클 레이스 마스터스 3위', '2007-09-07', '0000-00-00', 'tigerstar', '강호'),
(219, '철원 DMZ 하프 8위', '2007-09-18', '0000-00-00', 'run4joy', '강호'),
(218, '국제관광 하프 1위', '2007-09-18', '0000-00-00', 'run4joy', '김종철'),
(267, '광주시민 건강달리기 10km 3위입', '2008-05-08', '0000-00-00', 'syj5933', '김경아'),
(222, '금수산산악마라톤 4위 입상', '2007-10-08', '0000-00-00', 'tigerstar', '김종철'),
(223, '천안 이봉창의사 하프대회 우승', '2007-10-14', '0000-00-00', 'yd58a', '안현민'),
(225, '부여마라톤대회 하프 3위 입상', '2007-10-15', '0000-00-00', 'yd58a', '강호'),
(228, '이봉창대회 10키로 연대별 1위', '2007-10-18', '0000-00-00', 'sintofood', '정관택'),
(234, '춘천마라톤 5위 입상', '2007-10-28', '0000-00-00', 'run4joy', '강호'),
(235, '메트로 건강마라톤 10km 2위', '2007-11-10', '0000-00-00', 'run4joy', '강호'),
(238, '마라토니아데이 5km계주 1위', '2007-11-11', '0000-00-00', 'run4joy', '분당마라톤클럽'),
(239, '득남을 축하합니다!', '2007-11-20', '0000-00-00', 'bluesky', '강성복'),
(249, '전국파워런 풀코스 여자1위', '2007-11-26', '0000-00-00', 'sintofood', '손연자'),
(256, '인천국제마라톤 2연패 축하', '2008-03-31', '0000-00-00', 'run4joy', '강호'),
(252, '어린천사돕기 10km 3위', '2008-02-03', '0000-00-00', 'run4joy', '강호'),
(253, '한강동계마라톤 대회 10km 4위', '2008-02-04', '0000-00-00', 'run4joy', '김종철'),
(254, '서울마라톤 대회 단체전 3위', '2008-03-05', '0000-00-00', 'run4joy', '분당마라톤클럽'),
(260, '함평 나비 대회 하프 2위', '2008-04-14', '0000-00-00', 'run4joy', '안현민'),
(259, '함평 나비 대회 하프 1위', '2008-04-14', '0000-00-00', 'run4joy', '강호'),
(261, '천안상록하프 2위입상', '2008-05-03', '0000-00-00', 'yd58a', '강호'),
(263, '소아암대회10km 4위 입상', '2008-05-05', '0000-00-00', 'mylee8727', '박하명'),
(264, '소아암대회 10km 5위 입상', '2008-05-05', '0000-00-00', 'mylee8727', '김영헌A'),
(265, '소아암대회 하프 8위 입상', '2008-05-05', '0000-00-00', 'mylee8727', '황규철'),
(286, '남한산성산악마라톤18km2위입상', '2008-05-12', '0000-00-00', 'iks7777', '손연자'),
(287, '보성마라톤 하프2위 입상', '2008-05-14', '0000-00-00', 'mylee8727', '강호'),
(289, '전국효마라톤 하프 2위입상', '2008-05-25', '0000-00-00', 'dkceramic', '손연자'),
(290, '서울시장기 하프 전체2위', '2008-06-16', '0000-00-00', 'bluesky', '강호'),
(292, '새벽 강변마라톤 풀 전체10위!', '2008-07-07', '0000-00-00', 'bluesky', '안현민'),
(293, '중량천 50km울트라 5위', '2008-07-08', '0000-00-00', 'bluesky', '김영근'),
(296, '철원대회 10km 40대 4위 입상', '2008-09-23', '0000-00-00', 'run4joy', '유성복'),
(297, '변호사협회 마라톤 하프 전체3위', '2008-09-29', '0000-00-00', 'bluesky', '김종철');
