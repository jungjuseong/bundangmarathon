CREATE TABLE member (
  userid varchar(12) NOT NULL,
  passwd varchar(12) default '',
  name varchar(10),
  nickname varchar(20),
  sex char(1),
  juminno varchar(14),
  org varchar(30),
  orghref varchar(50),
  email varchar(30),
  postno varchar(7),
  postaddr varchar(60),
  photo varchar(15),
  telhome varchar(15),
  teloffice varchar(15),
  telhand varchar(15),
  size varchar(10),
  membertype varchar(10),
  grade varchar(12),
  disporder varchar(2) default '99',
  gumpuno smallint unsigned,
  indate varchar(200), // 입회일에서 회원정보로 내용 변경
  boston varchar(50),
  bloodtype varchar(3),
  etc varchar(200),
  PRIMARY KEY (userid)
);

CREATE TABLE race (
  raceid smallint unsigned NOT NULL auto_increment,
  name varchar(60) DEFAULT '' NOT NULL,
  nickname varchar(15) DEFAULT '' NOT NULL,
  raceday varchar(10) NOT NULL,
  racetime varchar(5),
  organizer varchar(30),
  homehref varchar(60),
  place varchar(20),
  typenfee varchar(40),
  etc varchar(100),
  inviting char(1),
  userid varchar(12),
  modifier varchar(12),
  PRIMARY KEY (raceid),
  UNIQUE nickname (nickname)
);

CREATE TABLE record (
  raceid smallint NOT NULL,
  userid varchar(12) NOT NULL,
  nickname varchar(15) NOT NULL,
  item varchar(8) NOT NULL,
  size varchar(4) NOT NULL,
  transport varchar(20),
  record varchar(10) NOT NULL,
  rank varchar(12),
  dispyn varchar(2) NOT NULL,
  groupyn varchar(1) NOT NULL,
  etc varchar(50),
  PRIMARY KEY (raceid, userid, item)
);

CREATE TABLE poll (
  pollid varchar(10) NOT NULL,
  userid varchar(12) NOT NULL,
  polltime datetime,
  poll0 varchar(20),
  poll1 varchar(20),
  poll2 varchar(20),
  poll3 varchar(20),
  poll4 varchar(20),
  poll5 varchar(20),
  poll6 varchar(20),
  poll7 varchar(20),
  poll8 varchar(20),
  poll9 varchar(20),
  PRIMARY KEY (pollid, userid)
);

CREATE TABLE book (
  yyyymmdd VARCHAR(10) NOT NULL,
  no int unsigned NOT NULL auto_increment,
  incomment VARCHAR(20),
  incash INT,
  outcomment VARCHAR(20),
  outcash INT,
  remains INT,
  comment VARCHAR(40),
  approval VARCHAR(12),
  userid VARCHAR(12) NOT NULL,
  inputtime DATETIME NOT NULL,
  PRIMARY KEY (yyyymmdd, no)
);

CREATE TABLE training (
  yyyymmdd VARCHAR(10) NOT NULL,
  name VARCHAR(10) NOT NULL,
  userid VARCHAR(12) NOT NULL,
  onoff CHAR(1),
  PRIMARY KEY (yyyymmdd, name, userid)
);

CREATE TABLE message (
  type VARCHAR(10) NOT NULL,
  yyyymmdd VARCHAR(10) NOT NULL,
  msg TEXT,
  PRIMARY KEY (type, yyyymmdd)
);

CREATE TABLE etc (
  type VARCHAR(10) NOT NULL,
  userid VARCHAR(12) NOT NULL,
  msgstr VARCHAR(50),
  msgint VARCHAR(13),
  PRIMARY KEY (type, userid)
);


CREATE TABLE epigram (
  no INT NOT NULL,
  words TEXT NOT NULL,
  in_date DATE,
  author VARCHAR(20),
  PRIMARY KEY (no)
);

CREATE TABLE chuka (
  no INT NOT NULL auto_increment,
  name varchar(10) NOT NULL,
  memo varchar(30) NOT NULL,
  in_date DATE NOT NULL,
  end_date DATE NOT NULL,
  userid VARCHAR(12) NOT NULL,
  PRIMARY KEY (no)
);

CREATE TABLE nabbuitem (
  no INT NOT NULL auto_increment,
  name varchar(20) NOT NULL,
  won INT NOT NULL,
  in_date DATE NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  allok char(1) default 'N' NOT NULL,
  PRIMARY KEY (start_date)
);

CREATE TABLE nabbudetail (
  no INT NOT NULL auto_increment,
  userid VARCHAR(12) NOT NULL,
  name varchar(10) NOT NULL,
  nabbuno INT NOT NULL,
  nabbu_date DATE,
  status char(1) default 'N' NOT NULL, // N(미납), S(신고), Y(확인)
  etc varchar(40),
  PRIMARY KEY (userid)
);

CREATE TABLE minipollq (
  pollno int(5) NOT NULL,
  userid varchar(12) NOT NULL,
  question varchar(80),
  items int(2),
  answers varchar(100),
  etc varchar(40),
  start_date DATE NOT NULL,
  stop_date DATE NOT NULL,
  polltime datetime,
  PRIMARY KEY (pollno)
);

CREATE TABLE minipolla (
  pollno int(5) NOT NULL auto_increment,
  userid varchar(12) NOT NULL,
  polltime datetime,
  selected varchar(20),
  etc varchar(40),
  PRIMARY KEY (pollno,userid)
);

CREATE TABLE score (
  no INT(20) unsigned NOT NULL,
  name varchar(20) NOT NULL,
  boardtype varchar(20) NOT NULL,
  score INT,
  PRIMARY KEY (no, name, boardtype)
);

CREATE TABLE scoresum (
  no INT(20) unsigned NOT NULL,
  name varchar(20) NOT NULL,
  scoresum INT,
  PRIMARY KEY (no, name)
);

----------------------------------------------
insert into score (no, name, boardtype, score) select ismember, name, 'memboard', count(*) from zetyx_board_memboard where FROM_UNIXTIME(reg_date) >='2006-01-01' group by ismember, name
insert into score (no, name, boardtype, score) select ismember, name, 'pubboard', count(*) from zetyx_board_pubboard where FROM_UNIXTIME(reg_date) >='2006-01-01' group by ismember, name
insert into score (no, name, boardtype, score) select ismember, name, 'photo', count(*) from zetyx_board_photo where FROM_UNIXTIME(reg_date) >='2006-01-01' group by ismember, name

insert into score (no, name, boardtype, score) select ismember, name, 'memboardadd', count(*) from zetyx_board_comment_memboard where FROM_UNIXTIME(reg_date) >='2006-01-01' group by ismember, name
insert into score (no, name, boardtype, score) select ismember, name, 'pubboardadd', count(*) from zetyx_board_comment_pubboard where FROM_UNIXTIME(reg_date) >='2006-01-01' group by ismember, name
insert into score (no, name, boardtype, score) select ismember, name, 'photoadd', count(*) from zetyx_board_comment_photo where FROM_UNIXTIME(reg_date) >='2006-01-01' group by ismember, name

insert into scoresum (no, name) select no, name from score order by no, name
update scoresum set scoresum = select score * 10 from score where boardtype='memboard'

select * from score order by name;

select ismember, FROM_UNIXTIME(reg_date) from zetyx_board_memboard where name='김영헌A' and FROM_UNIXTIME(reg_date) >='2006-01-01'
select ismember, FROM_UNIXTIME(reg_date) from zetyx_board_pubboard where name='김영헌A' and FROM_UNIXTIME(reg_date) >='2006-01-01'

-----------------------------------------------

CREATE TABLE trainingprogram (
  no int unsigned NOT NULL auto_increment,
  title VARCHAR(50) NOT NULL,
  distance VARCHAR(10),
  target VARCHAR(10),
  weeks INT,
  developer VARCHAR(20),
  source VARCHAR(20),
  memo TEXT NOT NULL,
  PRIMARY KEY (no)
);

insert into trainingprogram (2, '분당마라톤클럽 풀코스 16주 훈련 프로그램', '42.195km', '', 16, '강호', '분당마라톤클럽', '분당마라톤클럽 강호님이 개발한 풀코스 16주 훈련 프로그램
의무사항: 1. 훈련 프로그램의 90% 이상 실시, 2. 부상 당하지 않도록 훈련 프로그램보다 더 많은 훈련을 하지 않으며, 부상 징후가 보일 경우 즉시 훈련 중단, 3. 훈련 내용은 일체 외부에 알려지지 않아야 함');
insert into trainingprogram (1, '분당마라톤클럽 풀코스 16주 Sub-3 훈련 프로그램', '42.195km', 'Sub-3', 16, '강호', '분당마라톤클럽', '분당마라톤클럽 강호님이 개발한 Sub-3용 풀코스 16주 훈련 프로그램
의무사항: 1. 훈련 프로그램의 90% 이상 실시, 2. 부상 당하지 않도록 훈련 프로그램보다 더 많은 훈련을 하지 않으며, 부상 징후가 보일 경우 즉시 훈련 중단, 3. 훈련 내용은 일체 외부에 알려지지 않아야 함');


CREATE TABLE daytraining (
  no int unsigned NOT NULL,
  week smallint unsigned NOT NULL,
  dweek smallint unsigned NOT NULL,
  day smallint unsigned NOT NULL,
  memo TEXT NOT NULL,
  type VARCHAR(20),
  km VARCHAR(8),
  minutes INT(3),
  PRIMARY KEY (no, dweek, day)
);

insert into daytraining (1,16,1,1,'휴식','','',0); 
insert into daytraining (1,16,1,2,'3000m 조깅 + 2000m 템포런 2회 / 대회페이스보다 5~7초 빠르게 / 400m 휴식 + 3000m 조깅','템포런','',0); 
insert into daytraining (1,16,1,3,'2000m 조깅 + 5000m 대회 페이스주 1회 / 1000m 조깅','페이스주','5km',0); 
insert into daytraining (1,16,1,4,'휴식(식이요법 하는 사람) 또는 2000m 조깅 + 3000m 대회페이스 보다 3~5초 빠르게 1회 + 빠른 조깅 3000m(식이요법 하지 않는 사람)','','',0); 
insert into daytraining (1,16,1,5,'2000m 조깅 + 3000m 대회페이스 보다 3~5초 빠르게 1회 + 빠른 조깅 3000m(식이요법 하는 사람) 또는 휴식(식이요법 하지 않는 사람)','','',0); 
insert into daytraining (1,16,1,6,'1000m 질주 (5000~7000m 조깅 후 1000m 를 가능한 빠르게...)','','',0); 
insert into daytraining (1,16,1,7,'목표 기록으로의 완주 성공...','레이스','42.195km',0); 
insert into daytraining (1,15,2,1,'휴식','','',0); 
insert into daytraining (1,15,2,2,'8000m 지속주 (마라톤 계획 페이스보다 5초 가량 빠르게) (본 훈련 전, 후로 15분 가량 조깅)','지속주','',0); 
insert into daytraining (1,15,2,3,'70분 정도의 크로스 컨트리 또는 언덕훈련 (400m * 8회)','크로스 컨트리','',0); 
insert into daytraining (1,15,2,4,'3000m 지속주 2회 (마라톤 페이스보다 7초 가량 빠르게) (본 훈련 전, 후로 15분 가량 조깅)','지속주','',0); 
insert into daytraining (1,15,2,5,'조깅 40분 + 피엠 훈련 종합 (본인이 취약하다고 생각되는 항목 중심으로 4개 종목 20~30분)','','',0); 
insert into daytraining (1,15,2,6,'휴식','','',0); 
insert into daytraining (1,15,2,7,'6km 조깅 + 10km 페이스주 (마라톤 페이스)','페이스주','',0); 
insert into daytraining (1,14,3,1,'휴식','','',0); 
insert into daytraining (1,14,3,2,'마라톤 페이스보다 3~5초/km 빠르게 4000m 템포런 2회. 휴식 5분','템포런','',0); 
insert into daytraining (1,14,3,3,'40분 정도 천천히 조깅을 즐기시고 각근력 향상을 위한 PM 훈련을 20분 정도(종목은 자유)','','',0); 
insert into daytraining (1,14,3,4,'마라톤 페이스보다 3~5초 빠르게 10km 지속주 1회','지속주','',0); 
insert into daytraining (1,14,3,5,'40분 정도 천천히 조깅을 즐기시고 각근력 향상을 위한 PM 훈련을 20분 정도(종목은 자유)','','',0); 
insert into daytraining (1,14,3,6,'우동코스 크로스 컨트리 5회','크로스 컨트리','',0); 
insert into daytraining (1,14,3,7,'하프 지속주 (전반 53: 후반 47)','지속주','',0); 
insert into daytraining (1,13,4,1,'휴식','','',0); 
insert into daytraining (1,13,4,2,'10분 조깅 + 30분 지속주 (시간은 km 당 속도임) 1회 + 10~15분 조깅','지속주','',0); 
insert into daytraining (1,13,4,3,'조깅 40분 + PM 
 양발 2계단씩 뛰어 오르기 (4sets), 계단 점프 (자세에 특히 유의하며 4sets), 외발 겅중뛰기 (3sets/양발)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0); 
insert into daytraining (1,13,4,4,'4:00 페이스로 1600m 질주 + 2분 조깅 + 3:53 페이스로 1600m 질주 + 2분 이상 휴식 + 3:46 페이스로 1600m 질주 + 5분 휴식 후 한 세트 더 (본 훈련 전.후 15분 조깅)','','',0); 
insert into daytraining (1,13,4,5,'조깅 40분 + PM 
 겅중뛰기 30~40m*3세트, 런지웍/팔꿈치-복숭아뼈 대기 (12보*2*2), 세단뛰기(6회*4세트 : 도움닫기나 도약을 하면 안됨), 제자리빨리뛰기(75보*3세트/무릎을 높이)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0); 
insert into daytraining (1,13,4,6,'10k 지속주 (자신의 마라톤 목표 페이스)','지속주','',0); 
insert into daytraining (1,13,4,7,'2시간 시간주 (24~30km정도)','시간주','',120); 
insert into daytraining (1,12,5,1,'휴식','','',0); 
insert into daytraining (1,12,5,2,'4000m 지속주 2회(km당 3:55)','지속주','',0); 
insert into daytraining (1,12,5,3,'조깅 40분 + PM
 겅중뛰기 30~40m*3세트, 런지웍/팔꿈치-복숭아뼈대기 (12보*2*2), 세단뛰기 (6회*4세트 : 도움닫기나 도약을 하면 안됨), 제자리빨리뛰기(75보*3세트 / 무릎을 높이)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0); 
insert into daytraining (1,12,5,4,'자신의 하프 페이스보다  4~5초/km 빠르게 10분 인터벌 3회','인터벌','',0); 
insert into daytraining (1,12,5,5,'조깅 40분 + PM 
 턱점프 (12회 *4회), 외발 겅중뛰기 (30~40m *3sets/양발), 수직점프2회후 넓이뛰기 (10회 *3세트), 런지점프(20초 * 3sets)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0); 
insert into daytraining (1,12,5,6,'5000m time trial','','',0); 
insert into daytraining (1,12,5,7,'42km 거리주 (마지막 장거리 주)','거리주','',0); 
insert into daytraining (1,11,6,1,'휴식','','',0); 
insert into daytraining (1,11,6,2,'800m 인터벌(2:54) * 8회','인터벌','',0); 
insert into daytraining (1,11,6,3,'조깅 40분 + PM 
 턱점프 (12회 *4회), 외발 겅중뛰기 (30~40m *3sets/양발), 수직점프2회후 넓이뛰기 (10회 *3세트), 런지점프(20초 * 3sets)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0); 
insert into daytraining (1,11,6,4,'25분 지속주(3:55 페이스), 아주 중요한 훈련','지속주','',0); 
insert into daytraining (1,11,6,5,'조깅 40분 + PM
 2계단씩 빨리 뛰어오르기 (12단 * 4세트), 계단점프 (자세에 특히 유의 : 12단 * 4세트), 제자리빨리뛰기 (50회 * 4세트), 외발 2단점프 (8단 *2세트/ 양발)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0); 
insert into daytraining (1,11,6,6,'60분 자유주','','',0); 
insert into daytraining (1,11,6,7,'우동코스 크로스 컨트리 훈련 (7회 또는 80분)','크로스 컨트리','',0); 
insert into daytraining (1,10,7,1,'40분 조깅 (마라톤 페이스의 80%)','','',0);
insert into daytraining (1,10,7,2,'15분 조깅 + [25분 지속주 (4:12~4:14 페이스) 1회] 또는 [10분 인터벌(1:33/400m 속도로 10분간 달리고 휴식주 5분) 3세트] + 10~15분 조깅','','',0);
insert into daytraining (1,10,7,3,'조깅 40분 + PM 
 양발 2계단씩 뛰어 오르기 (4sets) , 계단 점프 (자세에 특히 유의하며 4sets), 외발 겅중뛰기 (3sets/양발)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,10,7,4,'4:00 페이스로 1600m 질주 + 2분 조깅 + 3:53 페이스로 1600m 질주 + 2분 이상 휴식 + 3:46 페이스로 1600m 질주 + 5분 휴식 후 한 세트 더 (본 훈련 전.후 15분 조깅)','','',0);
insert into daytraining (1,10,7,5,'조깅 40분 + PM 
 겅중뛰기 30~40m*3세트, 런지웍/팔꿈치-복숭아뼈대기 (12보*2*2), 세단뛰기 (6회*4세트 : 도움닫기나 도약을 하면 안됨), 제자리빨리뛰기(75보*3세트 / 무릎을 높이)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,10,7,6,'휴식','','',0);
insert into daytraining (1,10,7,7,'2시간 시간주 (24~30km정도)','시간주','',0);
insert into daytraining (1,9,8,1,'휴식','','',0);
insert into daytraining (1,9,8,2,'15분 조깅 + 6분 인터벌(3:50 페이스, 400m 93초) 2세트 (휴식=2분 이내) + 15분 조깅','','',0);
insert into daytraining (1,9,8,3,'조깅 40분 + PM
 겅중뛰기 30~40m*3세트, 런지웍/팔꿈치-복숭아뼈대기 (12보*2*2), 세단뛰기 (6회*4세트 : 도움닫기나 도약을 하면 안됨), 제자리빨리뛰기(75보*3세트 / 무릎을 높이)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,9,8,4,'800m run(3:07) + 2분 휴식 + 400 run(1:30) + 1분 걷기 + 200 run(40초) + 30초 휴식 + 1000 run(3:53), 2세트 실시/세트간 휴식은 5분','','',0);
insert into daytraining (1,9,8,5,'조깅 40분 + PM 
 턱점프(12*4) 외발겅중 (30~40m *3세트*양발), 수직점프 2회 후 넓이뛰기 (10회 * 3세트), 런지점프(20초 * 3세트)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,9,8,6,'우동코스 크로스 컨트리 (60분)','','',0);
insert into daytraining (1,9,8,7,'LSD 거리?','','',0);
###### 위 내용 수정(워크샵)
insert into daytraining (1,8,9,1,'휴식 또는 가벼운 조깅','','',0);
insert into daytraining (1,8,9,2,'4:00 페이스로 1600m 질주 + 2분 조깅 + 3:53 페이스로 1600m 질주 + 2분 이상 휴식 + 3:46 페이스로 1600m 질주 + 5분 휴식 후 한 세트 더(본 훈련 전.후 15분 조깅)','','',0);
insert into daytraining (1,8,9,3,'조깅 40분 + PM 
 턱점프 (12회*4세트), 외발 2계단 뛰어오르기 (8회*2세트/각발 : 자세에 특히 유의할 것), 수직점프2회후 넓이뛰기(10회*3세트), 런지점프 (20초 연속)*3세트)
 * 각 세트간 휴식은 1~2분, 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,8,9,4,'5분 인터벌(3:43 페이스) 3세트(주말 대회 미참가자는 4세트 실시), 휴식주 3~5분','인터벌','',0);
insert into daytraining (1,8,9,5,'조깅 40분 +PM
 계단 2단 뛰어 오르기(12단 4세트), 계단 2단 점프(8단 4세트), 외발 겅중뛰기 (12보 3세트 각발마다)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,8,9,6,'휴식','','',0);
insert into daytraining (1,8,9,7,'40km LSD or 대회 참가','','',0);
insert into daytraining (1,7,10,1,'휴식','','',0);
insert into daytraining (1,7,10,2,'800m 인터벌(2:54) * 6회','인터벌','',0);
insert into daytraining (1,7,10,3,'조깅 40분 + PM 
 계단 2단 점프 8회*4세트, 계단 2단 뛰어오르기 12회*4세트, 외발 겅중뛰기 10회*2세트 (각 발), 외발 계단 점프 8회*2세트 (각 발)
 * 세트간 휴식 1분, 종목간 휴식 2분','','',0);
insert into daytraining (1,7,10,4,'언덕훈련  8~10회(수지 신봉동 홍천중학교 언덕), 10km 대회 페이스로 오르고 천천히 완전히 회복하며 내려오기','언덕훈련','',0);
insert into daytraining (1,7,10,5,'조깅 40분 + PM
 겅중뛰기 30~40m*3세트, 런지웍/팔꿈치-복숭아뼈대기 (12보*2*2), 세단뛰기 (6회*4세트 : 도움닫기나 도약을 하면 안됨), 제자리빨리뛰기(75보*3세트 / 무릎을 높이)
 *세트간 휴식 1분, 종목간 휴식 2분','','',0);
insert into daytraining (1,7,10,6,'지속주 (10~14K), 자신의 하프마라톤 페이스로 달리기','','',0);
insert into daytraining (1,7,10,7,'우동코스 크로스 컨트리 6회','크로스 컨트리','',0);
insert into daytraining (1,6,11,1,'휴식','','',0);
insert into daytraining (1,6,11,2,'언덕훈련 (90초 내외) 6회~8회 (수지 신봉동 홍천중학교 언덕), 주택전시관 언덕 훈련자는 8~12회, 10km 대회 페이스로 오르고 천천히 완전히 회복하며 내려오기(횟수는 지난 일요일 35km 이상 훈련한 사람은 적은 수를 그렇지 못한 사람은 많은 수를 적용.)','언덕훈련','',0);
insert into daytraining (1,6,11,3,'조깅 40분 + PM
 겅중뛰기 30~40m*3세트, 런지웍/팔꿈치-복숭아뼈대기 (12보*2*2), 세단뛰기 (6회*4세트 : 도움닫기나 도약을 하면 안됨), 제자리빨리뛰기(75보*3세트 / 무릎을 높이)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,6,11,4,'15분 조깅 + [800m run(3:07) + 2분 휴식 + 400 run(1:30) + 1분 걷기 + 200 run(40초) + 30초 휴식 + 1000 run(3:53)] 3세트 실시, 세트간 휴식은 5분 + 정리운동 15분','','',0);
insert into daytraining (1,6,11,5,'조깅 40분 + PM 
 턱점프 (12회 *4회), , 외발 겅중뛰기 (30~40m *3sets/양발), 수직점프2회후 넓이뛰기 (10회 *3세트), 런지점프(20초 * 3sets)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,6,11,6,'우동코스 크로스 컨트리','크로스 컨트리','',0);
insert into daytraining (1,6,11,7,'LSD 거리?','','',0);
###### 위 내용 수정(신년 달리기)
insert into daytraining (1,5,12,1,'휴식','','',0);
insert into daytraining (1,5,12,2,'언덕훈련(수지 신봉동 홍천중학교), 90초 내외 6~8회 실시(10K 대회 페이스로 숨가쁘게 오른 후 내려오면서 완전 회복)','언덕훈련','',0);
insert into daytraining (1,5,12,3,'조깅 40분 + PM 
 턱점프(12*4), 외발겅중 (30~40m *3세트*양발), 수직점프 2회 후 넓이뛰기 (10회 * 3세트), 런지점프(20초 * 3세트)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,5,12,4,'15분 조깅 + 6분 인터벌(3:50 페이스, 400m 93초) 3세트 (휴식=2분 이내) + 15분 조깅','','',0);
insert into daytraining (1,5,12,5,'조깅 40분 + PM 
 2계단씩 빨리 뛰어오르기 (12단 * 4세트), 계단점프(자세에 특히 유의 : 12단 * 4세트), 외발 2단점프 (8단 *2세트/ 양발)
  * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,5,12,6,'6km 지속주(4:08 페이스 이내)(일요일 40km 장거리주를 못할 경우 지속주 거리를 10km로 늘릴 것. 일요일 장거리주를 할 경우 절대 6km 이상 달리지 말고 총거리도 10km를 넘기지 말 것)','','',0);
insert into daytraining (1,5,12,7,'40k 장거리주','','',0);
insert into daytraining (1,4,13,1,'40분 조깅(마라톤 페이스의 75~80%)','','',0);
insert into daytraining (1,4,13,2,'15분 조깅 + [25분 지속주 (4:12~4:14 페이스) 1회] 또는 [10분 인터벌(1:33/400m 속도로 10분간 달리고 휴식주 5분) 3세트] + 10~15분 조깅','','',0);
insert into daytraining (1,4,13,3,'조깅 40분 + PM 
 양발 2계단씩 뛰어 오르기 (4sets) , 계단 점프 (자세에 특히 유의하며 4sets), 외발 겅중뛰기 (3sets/양발)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,4,13,4,'언덕훈련 (90초 내외) 8회~10회(언덕은 10km 대회 페이스로 오르고 천천히 완전히 회복하며 내려오기)','','',0);
insert into daytraining (1,4,13,5,'조깅 40분 + PM 
 겅중뛰기 30~40m*3세트, 런지웍/팔꿈치-복숭아뼈대기 (12보*2*2), 세단뛰기 (6회*4세트 : 도움닫기나 도약을 하면 안됨), 제자리빨리뛰기(75보*3세트 / 무릎을 높이)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,4,13,6,'휴식','','',0);
insert into daytraining (1,4,13,7,'하프 대회 참가','','',0);
insert into daytraining (1,3,14,1,'휴식','','',0);
insert into daytraining (1,3,14,1,'언덕훈련 (90초 내외) 6~10회(언덕은 10km 대회 페이스로 오르고 천천히 완전히 회복하며 내려오기)','','',0);
insert into daytraining (1,3,14,1,'조깅 40분 + PM
 겅중뛰기 30~40m * 3세트, 런지웍 및 팔꿈치-복숭아뼈 대기 (12보 *2 *2), 세단뛰기(6회*4세트 ; 도움닫기나 도약을 하면 안됨, 제자리빨리뛰기 (75회 * 3세트 / 무릎을 높이)
 * 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,3,14,1,'5분 인터벌(3:43 페이스) 3세트, 휴식주 3~5분','','',0);
insert into daytraining (1,3,14,1,'조깅 40분 +PM
 턱점프 (12회*4세트), 외발 2계단 뛰어오르기 (8회*2세트/각발 : 자세에 특히 유의할 것), 수직점프2회후 넓이뛰기(10회*3세트), 런지점프 (20초 연속*3세트)
 * 각 세트간 휴식은 1~2분, 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,3,14,1,'5km Time Trial','','',0);
insert into daytraining (1,3,14,1,'크로스 컨트리 75분 (중강도 / 마라톤 페이스의 85~90%)','','',0);
insert into daytraining (1,2,15,1,'휴식 또는 30분 정도의 조깅','','',0);
insert into daytraining (1,2,15,2,'10분 지속주(3:53 페이스) 2회 (휴식 5분)','지속주','',0);
insert into daytraining (1,2,15,3,'언덕훈련 (75~90초) 또는 PM(턱점프 12회 * 4 / 외발점프 8회 * 2 (계단에서 각 발마다) / 런지점프 20초 / 높이뛰기연속2번+넓이뛰기1번 * 10회 * 3세트)','','',0);
insert into daytraining (1,2,15,4,'4:00 페이스로 1600m 질주 + 2분 조깅 + 3:53 페이스로 1600m 질주 + 2분 이상 휴식 + 3:46 페이스로 1600m 질주 + 5분 휴식 후 한 세트 더 실시(본 훈련 전.후 15분 조깅)','','',0);
insert into daytraining (1,2,15,5,'조깅 + PM(계단 훈련)','','',0);
insert into daytraining (1,2,15,6,'휴식','','',0);
insert into daytraining (1,2,15,7,'2시간 30분 시간주 (거리는 30km 정도)','시간주','',150);
insert into daytraining (1,1,16,1,'휴식','','',0);
insert into daytraining (1,1,16,2,'조깅 15분 + [3:05로 800m 질주 + 2분 휴식 + 1:29로 400m 질주 + 1분 걷기 + 32초로 200m + 30초 휴식 + 3:51로 1000m] 2세트, 세트간 휴식은 5분 + 정리운동 15분','복합인터벌','',0);
insert into daytraining (1,1,16,3,'40분 조깅 + PM
 계단 2단 뛰기 4세트, 계단 점프 4세트, 외발 뛰기 3세트(각발)
 * 계단은 총 단수가 20~24단 정도, 각 세트간 휴식은 1~2분; 종목간 휴식은 3분 이내','','',0);
insert into daytraining (1,1,16,4,'조깅 15분 + 20분 지속주(3:56 페이스) + 정리운동 15분','지속주','',0);
insert into daytraining (1,1,16,5,'조깅 50분 + PM
 제자리뛰기 75회 (각발) * 3세트, 겅중뛰기 30~40m * 3세트, 런지웍 12보 * 2회, 팔꿈치복숭아뼈대기 12보 * 2회, 겅중,겅중,점프 6회 * 4세트)','','',0);
insert into daytraining (1,1,16,6,'조깅 +  4:02/km 속도로 5km 달리기 + 조깅','지속주','',0);
insert into daytraining (1,1,16,7,'언덕 훈련','','',0);
#### 2005.11.27 정모 언덕훈련

 
CREATE TABLE mytraining (
  userid varchar(12) NOT NULL,
  no int unsigned NOT NULL,
  raceid smallint unsigned NOT NULL,
  raceday DATE NOT NULL,
  start DATE NOT NULL,
  memo TEXT NOT NULL,
  PRIMARY KEY (userid, no)
);

insert into mytraining('run4joy', 1, 360, '2006-10-29', 2006-06-01', '춘천에서 꼭 Sub-3 달성한다');

CREATE TABLE trainingcomment (
  no int unsigned NOT NULL,
  type VARCHAR(20) NOT NULL,
  memo TEXT NOT NULL,
  PRIMARY KEY (no, type)
);
insert into trainingcomment(1, '크로스 컨트리', '우동코스 위치 : 분당 정든마을 우성아파트 건너편 등산로 입구(이마트에서 하이마트를 지나 중앙고등학교 바로 뒷편이며, 이마트 맞은 편 아파트가 동아아파트고 동아아파트 뒷편에 우성아파트가 있다)');

CREATE TABLE clubtraining (
  tday DATE NOT NULL,
  memo TEXT NOT NULL,
  type VARCHAR(20),
  PRIMARY KEY (tday)
);
insert into clubtraining values ('2006-09-18','휴 식','');
insert into clubtraining values ('2006-09-19','15분 조깅 + 4000m * 2회/합동훈련(탄천종합운동장) 19:00~21:00','');
insert into clubtraining values ('2006-09-20','조깅 40분후 기초근력 강화훈련(PM훈련)','');
insert into clubtraining values ('2006-09-21','15분 조깅 + 1000m 인터벌 8회/합동훈련(탄천종합운동장) 19:00~21:00','');
insert into clubtraining values ('2006-09-22','조깅 40분후 기초근력 강화훈련(PM훈련)','');
insert into clubtraining values ('2006-09-23','남한산성 크로스컨트리 07:00~09:00','');
insert into clubtraining values ('2006-09-24','정모 28km LSD','');
/* 수정 필요
insert into clubtraining values ('2006-09-25','휴 식','');
insert into clubtraining values ('2006-09-26','15분 조깅 + 4000m * 2회/합동훈련(탄천종합운동장) 19:00~21:00','');
insert into clubtraining values ('2006-09-27','조깅 40분후 기초근력 강화훈련(PM훈련)','');
insert into clubtraining values ('2006-09-28','15분 조깅 + 1000m 인터벌 8회/합동훈련(탄천종합운동장) 19:00~21:00','');
insert into clubtraining values ('2006-09-29','조깅 40분후 기초근력 강화훈련(PM훈련)','');
insert into clubtraining values ('2006-09-30','남한산성 크로스컨츄리 07:00~09:00','');
insert into clubtraining values ('2006-10-01','정모 42km LSD','');
*/
insert into clubtraining values ('2006-10-02','휴 식','');
insert into clubtraining values ('2006-10-03','15분 조깅 + 4Km 템포런 2회/합동훈련(주택전시관) 19:00~21:00','');
insert into clubtraining values ('2006-10-04','조깅 40분후 기초근력 강화훈련(PM훈련)','');
insert into clubtraining values ('2006-10-05','15분 조깅 + 1600m 인터벌/합동훈련(탄천종합운동장) 19:00~21:00','');
insert into clubtraining values ('2006-10-06','조깅 40분후 기초근력 강화훈련(PM훈련)','');
insert into clubtraining values ('2006-10-07','밤골(율새) 5회 크로스컨트리/율동 밤골코스 초입 07:00~09:00 ','');
insert into clubtraining values ('2006-10-08','3/4분기 하프 기록회','');
