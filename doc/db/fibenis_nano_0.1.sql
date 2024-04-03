-- 03APR2024
ALTER TABLE user_role ADD session_time INT NOT NULL DEFAULT '0' AFTER home_page_url; 

-- 10JAN2024
DROP FUNCTION IF EXISTS get_exav_addon_vc128uniq_match; 
DELIMITER $$
CREATE  FUNCTION get_exav_addon_vc128uniq_match(ec_id INT, token VARCHAR(32),token_value VARCHAR(128)) RETURNS tinyint(1)
BEGIN
    return IFNULL((SELECT count(*) FROM exav_addon_vc128uniq WHERE  parent_id=ec_id AND exa_token=token AND exa_value=token_value),0);     
END$$
DELIMITER ;

DROP FUNCTION IF EXISTS get_exav_addon_vc128uniq; 
DELIMITER $$
CREATE  FUNCTION get_exav_addon_vc128uniq(ec_id INT, token VARCHAR(32)) RETURNS text CHARSET utf8mb3
BEGIN
    return IFNULL((SELECT exa_value FROM exav_addon_vc128uniq WHERE  parent_id=ec_id AND exa_token=token),NULL);     
END$$
DELIMITER ;

ALTER TABLE exav_addon_vc128uniq ADD CONSTRAINT exav_vc128uniq_hash UNIQUE(exa_token,exa_value_hash); 
ALTER TABLE exav_addon_vc128uniq ADD INDEX exav_addon_vc128uniq_token_value(exa_token, exa_value(32));

-- 26DEC2023
DROP FUNCTION IF EXISTS get_user_internal_id;
DELIMITER $$
CREATE  FUNCTION get_user_internal_id(temp_id INT(11)) RETURNS int(11)
BEGIN
    RETURN IFNULL((SELECT is_internal FROM user_info WHERE id=temp_id),NULL);
END$$
DELIMITER ;

-- 30NOV2023
ALTER TABLE entity_child_base CHANGE sn sn VARCHAR(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NULL DEFAULT NULL; 

-- 17NOV2023
DROP FUNCTION IF EXISTS get_IST
DELIMITER $$
CREATE FUNCTION get_IST(temp_time datetime) RETURNS datetime
BEGIN
    return DATE_ADD(temp_time, INTERVAL '+9 30' HOUR_MINUTE);
END$$
DELIMITER ;

INSERT INTO 
            entity_child_base(entity_code,token,sn,ln,dna_code,line_order,created_by,user_id)
        VALUES
            ('IT','ITCB','Check Box','Check Box','EBMS',19,2,2);

-- 17OCT2023
INSERT INTO 
            entity_child_base(entity_code,token,sn,ln,dna_code,line_order,created_by,user_id)
        VALUES
            ('IT','ITHN','Hidden','Hidden','EBMS',18,2,2);

DELIMITER $$
CREATE FUNCTION get_user_internal(temp_user_id int,temp_ea_code varchar(32)) RETURNS text CHARSET utf8mb3
BEGIN
            return get_eav_addon_varchar((SELECT is_internal FROM user_info WHERE user_info.id=temp_user_id),temp_ea_code);
        END$$
DELIMITER ;

-- 10OCT2023
-- time
INSERT INTO 
            entity_child_base(entity_code,token,sn,ln,dna_code,line_order,created_by,user_id)
        VALUES
            ('IT','ITTI','Time','Time','EBMS',18,2,2);

DROP TABLE IF EXISTS exav_addon_time;
CREATE TABLE exav_addon_time (
  id int NOT NULL AUTO_INCREMENT,
  parent_id int DEFAULT NULL,
  exa_token varchar(32) NOT NULL,
  exa_value TIME DEFAULT NULL,
  user_id int DEFAULT NULL,
  timestamp_punch timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY (parent_id,exa_token,exa_value),
  KEY (exa_token,exa_value),
  KEY (timestamp_punch)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3; 
ALTER TABLE exav_addon_time ADD FOREIGN KEY (parent_id) REFERENCES entity_child(id) ON DELETE CASCADE ON UPDATE RESTRICT; 
ALTER TABLE exav_addon_time ADD FOREIGN KEY (exa_token) REFERENCES entity_child_base(token) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE exav_addon_time ADD FOREIGN KEY (user_id) REFERENCES user_info(id) ON DELETE RESTRICT ON UPDATE RESTRICT; 

DROP FUNCTION IF EXISTS get_exav_addon_time;
DELIMITER $$
CREATE  FUNCTION get_exav_addon_time(ec_id INT, token VARCHAR(32)) RETURNS TEXT
BEGIN
    return IFNULL((SELECT exa_value FROM exav_addon_time WHERE  parent_id=ec_id AND exa_token=token),NULL);
END$$
DELIMITER ;


-- 07OCT2023
-- entity_child_temp
DROP TABLE IF EXISTS entity_child_temp;
CREATE TABLE entity_child_temp(
  id int NOT NULL AUTO_INCREMENT,
  entity_code varchar(4) NOT NULL,
  created_by int DEFAULT NULL,
  creation datetime DEFAULT CURRENT_TIMESTAMP,
  user_id int DEFAULT NULL,
  timestamp_punch timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id), 
  KEY(entity_code) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3; 

ALTER TABLE entity_child_temp ADD FOREIGN KEY (entity_code) REFERENCES entity(code) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE entity_child_temp ADD FOREIGN KEY (user_id) REFERENCES user_info(id) ON DELETE RESTRICT ON UPDATE RESTRICT; 

DROP TABLE IF EXISTS ectv_addon_vc32;
CREATE TABLE ectv_addon_vc32 (
  id int NOT NULL AUTO_INCREMENT,
  parent_id int DEFAULT NULL,
  ect_token varchar(32) NOT NULL,
  ect_value varchar(32) DEFAULT NULL,
  user_id int DEFAULT NULL,
  timestamp_punch timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY (parent_id,ect_token,ect_value),
  KEY (timestamp_punch)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3; 

ALTER TABLE ectv_addon_vc32 ADD FOREIGN KEY (parent_id) REFERENCES entity_child_temp(id) ON DELETE CASCADE ON UPDATE RESTRICT; 
ALTER TABLE ectv_addon_vc32 ADD FOREIGN KEY (ect_token) REFERENCES entity_child_base(token) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE ectv_addon_vc32 ADD FOREIGN KEY (user_id) REFERENCES user_info(id) ON DELETE RESTRICT ON UPDATE RESTRICT; 

DROP FUNCTION IF EXISTS get_ectv_addon_vc32;
DELIMITER $$
CREATE  FUNCTION get_ectv_addon_vc32(ec_id INT, token VARCHAR(32)) RETURNS TEXT
BEGIN
    return IFNULL((SELECT ect_value FROM ectv_addon_vc32 WHERE  parent_id=ec_id AND ect_token=token),NULL);
END$$
DELIMITER ;

-- 06MAy2023
DELIMITER $$
DROP FUNCTION IF EXISTS get_ec_trans_count_addon_max$$
CREATE FUNCTION get_ec_trans_count_addon_max(temp_trans_addon_token varchar(32),temp_parent_id INT,temp_trans_addon_id INT) RETURNS DECIMAL
BEGIN
			RETURN IFNULL((SELECT ROUND(cb,2) FROM entity_child_trans_count_addon as trans_addon WHERE trans_addon_token=temp_trans_addon_token AND 
													ectc_parent_id = temp_parent_id AND
													trans_addon_id=temp_trans_addon_id
													ORDER BY id DESC LIMIT 1),0);
END$$


DROP FUNCTION IF EXISTS get_ec_trans_count_max$$
CREATE FUNCTION get_ec_trans_count_max(temp_trans_token varchar(32),temp_parent_id INT) RETURNS DECIMAL
BEGIN
			RETURN IFNULL((SELECT cb FROM entity_child_trans_count WHERE trans_token=temp_trans_token  AND parent_id=temp_parent_id ORDER BY id DESC LIMIT 0,1),0);
END$$
DELIMITER ;


-- 26Apr2023
DROP TABLE IF EXISTS entity_child_trans_count_addon;
CREATE TABLE entity_child_trans_count_addon (
  id int(11) NOT NULL AUTO_INCREMENT,
  ectc_parent_id int(11) NOT NULL,
  ectc_trans_id int(11) NOT NULL,
  trans_addon_token varchar(32) NOT NULL,
  trans_addon_id int(11) NOT NULL,
  ob decimal(14,4) DEFAULT NULL  COMMENT 'Opening Balamce',
  current_value decimal(14,4) DEFAULT NULL,
  cb decimal(14,4) DEFAULT NULL  COMMENT 'Closing Balamce',
  user_id int(11) NOT NULL,
  timestamp_punch timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),  
  KEY ectc_parent_id (ectc_parent_id),
  KEY trans_key_combo(ectc_parent_id,ectc_trans_id,trans_addon_token,trans_addon_id),
  KEY trans_key_child (trans_addon_token,trans_addon_id ),
  KEY parent_trans_id (ectc_parent_id,ectc_trans_id,trans_addon_id),
  KEY timestamp_punch (timestamp_punch),
  KEY user_id (user_id),
  CONSTRAINT fk_ec_trans_count_addon_parent_id FOREIGN KEY (ectc_parent_id) REFERENCES entity_child (id) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT fk_ec_trans_count_addon_trans_id FOREIGN KEY (ectc_trans_id) REFERENCES entity_child (id) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT fk_ec_trans_count_addon_id FOREIGN KEY (trans_addon_id) REFERENCES entity_child (id) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT fk_ec_trans_count_addon_user_id FOREIGN KEY (user_id) REFERENCES user_info (id) ON DELETE RESTRICT ON UPDATE RESTRICT		  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TRIGGER IF EXISTS ins_entity_child_trans_count_addon;			
delimiter $$
CREATE TRIGGER ins_entity_child_trans_count_addon BEFORE INSERT ON entity_child_trans_count_addon
       FOR EACH ROW
       BEGIN
			DECLARE open_balance DECIMAL(14,4);
			DECLARE closing_balance DECIMAL(14,4);
			
		   SET open_balance  = IFNULL((SELECT 
										cb 
									FROM 
										entity_child_trans_count_addon 
									WHERE 
										trans_addon_token=NEW.trans_addon_token AND
										ectc_parent_id=NEW.ectc_parent_id AND
										trans_addon_id=NEW.trans_addon_id ORDER BY ID DESC LIMIT 1),0);
	   
			SET NEW.ob          =  open_balance;
			SET closing_balance = (open_balance+new.current_value);
			SET NEW.cb          = closing_balance;
			
       END;$$
delimiter ;


DELIMITER $$
CREATE  FUNCTION get_ectc_addon_ec_id(ectc_id INT, temp_token varchar(32)) RETURNS int
BEGIN
    RETURN IFNULL((SELECT
							trans_addon_id 
					FROM 
							entity_child_trans_count_addon 
					WHERE  
							parent_id=ectc_id AND  
							trans_addon_token=temp_token),NULL);
END$$
DELIMITER ;

-- 12Apr2023
DELIMITER $$
CREATE  FUNCTION get_ecb_addon_ec_id(ecb_id INT, temp_code CHAR(4)) RETURNS int
BEGIN
    RETURN IFNULL((SELECT ec_id FROM ecb_av_addon_ec_id WHERE  parent_id=ecb_id AND ea_code=temp_code ORDER BY id DESC LIMIT 1),NULL);
END$$
DELIMITER ;


-- 11Apr20233
-- Adding EX entity 
INSERT INTO entity (code,sn,ln,creation,user_id,timestamp_punch,is_lib) VALUES ('EX','External Transaction Items','External Transaction Items',now(),2,now(),0);

-- Adding Coach Issue Transaction
INSERT INTO entity_child_base (entity_code,token,sn,ln,dna_code,created_by,creation,is_active,user_id,timestamp_punch) 
						VALUES ('EX','CHIS','Coach Issue','Coach Issue','EBMS',2,now(),1,2,now());


-- 10Apr2023
DROP TABLE IF EXISTS entity_child_trans_count;
CREATE TABLE entity_child_trans_count(
		  id int(11) NOT NULL AUTO_INCREMENT,
		  trans_token varchar(32) NOT NULL,
		  parent_id int(11) NOT NULL,
		  trans_entity_code char(4) NOT NULL,	
		  trans_id int(11) NOT NULL,		 
		  ob decimal(14,4) DEFAULT NULL  COMMENT 'Opening Balamce',
		  current_value decimal(14,4) DEFAULT NULL,
		  cb decimal(14,4) DEFAULT NULL  COMMENT 'Closing Balamce',
		  user_id int(11) NOT NULL,
		  timestamp_punch timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  PRIMARY KEY (id),
		  KEY trans_token_parent_id (trans_token,parent_id),
		  KEY parent_id (parent_id),
		  KEY trans_entity_code_trans_id (trans_entity_code,trans_id ),
		  KEY trans_id (trans_id),
		  KEY parent_trans_id (parent_id,trans_id),
		  KEY timestamp_punch (timestamp_punch),
		  KEY user_id (user_id),
		  CONSTRAINT fk_entity_child_trans_count_parent_id FOREIGN KEY (parent_id) REFERENCES entity_child (id) ON DELETE CASCADE ON UPDATE RESTRICT,
		  CONSTRAINT fk_entity_child_trans_count_trans_id FOREIGN KEY (trans_id) REFERENCES entity_child (id) ON DELETE CASCADE ON UPDATE RESTRICT,
		  CONSTRAINT fk_entity_child_trans_count_user_id FOREIGN KEY (user_id) REFERENCES user_info (id) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
																					
			
DROP TRIGGER IF EXISTS ins_entity_child_trans_count;			
delimiter //
CREATE TRIGGER ins_entity_child_trans_count BEFORE INSERT ON entity_child_trans_count
       FOR EACH ROW
       BEGIN
			DECLARE open_balance DECIMAL(14,4);
			DECLARE closing_balance DECIMAL(14,4);
			
		   SET open_balance  = IFNULL((SELECT 
										cb 
									FROM 
										entity_child_trans_count 
									WHERE 
										trans_token=NEW.trans_token AND
										parent_id=NEW.parent_id ORDER BY ID DESC LIMIT 1),0);
	   
			SET NEW.ob          =  open_balance;
			SET closing_balance = (open_balance+new.current_value);
			SET NEW.cb          = closing_balance;
			
       END;//
delimiter ;

-- 31Mar2023
DROP TABLE IF EXISTS ecb_av_addon_ec_id;
CREATE TABLE ecb_av_addon_ec_id(
  id int(11) NOT NULL AUTO_INCREMENT,
  parent_id int(11) DEFAULT NULL,
  ea_code char(4) DEFAULT NULL,
  ec_id int(11) NOT NULL,
  user_id int(11) DEFAULT NULL,
  timestamp_punch timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY ea_code (ea_code),
  KEY parent_id (parent_id),
  KEY ec_id (ec_id),
  KEY timestamp_punch (timestamp_punch),
  KEY user_id (user_id),
   CONSTRAINT fk_ecb_av_addon_ec_id_ea_code FOREIGN KEY (ea_code) REFERENCES entity_attribute (code) ON DELETE CASCADE ON UPDATE NO ACTION,
   CONSTRAINT fk_ecb_av_addon_ec_id_parent_id FOREIGN KEY (parent_id) REFERENCES entity_child_base (id) ON DELETE CASCADE ON UPDATE NO ACTION,
   CONSTRAINT fk_ecb_av_addon_ec_id_ec_id FOREIGN KEY (ec_id) REFERENCES entity_child (id) ON DELETE CASCADE ON UPDATE NO ACTION,
   CONSTRAINT fk_ecb_av_addon_ec_id_user_id FOREIGN KEY (user_id) REFERENCES user_info (id) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

INSERT INTO entity_attribute (entity_code, code, sn, ln, line_order, creation, user_id, timestamp_punch) VALUES
                             ('CH', 'CHID', 'Coach ID', '', '9.00',now(), 2,now());
                             
-- 14Feb2023
INSERT INTO entity_attribute (entity_code, code, sn, ln, line_order, creation, user_id, timestamp_punch) VALUES
                             ('CH', 'CHET', 'Coach Entity', '', '8.00',now(), 2,now());


-- 08NOV2022
INSERT INTO entity_attribute (entity_code, code, sn, ln, line_order, creation, user_id, timestamp_punch) VALUES
                             ('GP', 'GPIL', 'Is Core Group', '', '2.00',now(), 2,now());
							 
-- 12OCT2022
DROP TABLE IF EXISTS eav_addon_entity_code;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE eav_addon_entity_code (
  id int(11) NOT NULL AUTO_INCREMENT,
  parent_id int(11) DEFAULT NULL,
  ea_code char(4) DEFAULT NULL,
  entity_code varchar(4) NOT NULL,
  user_id int(11) DEFAULT NULL,
  timestamp_punch timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY ea_code (ea_code),
  KEY parent_id (parent_id),
  KEY timestamp_punch (timestamp_punch),
  KEY user_id (user_id),
  CONSTRAINT eav_addon_entity_code_id_ibfk_1 FOREIGN KEY (user_id) REFERENCES user_info (id),
  CONSTRAINT eav_addon_entity_code_ea_code_fk FOREIGN KEY (ea_code) REFERENCES entity_attribute (code) ON UPDATE CASCADE,
  CONSTRAINT eav_addon_entity_code_parent_id_fk FOREIGN KEY (parent_id) REFERENCES entity_child (id) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT eav_addon_entity_code_fk FOREIGN KEY (entity_code) REFERENCES entity(code) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


-- 11OCT2021
-- Addition of checkbox & radio column
ALTER TABLE demo ADD type_hidden VARCHAR(64) DEFAULT NULL AFTER text_flat;
ALTER TABLE demo ADD checkbox VARCHAR(64) DEFAULT NULL AFTER type_hidden;
ALTER TABLE demo ADD radio VARCHAR(64) DEFAULT NULL AFTER checkbox;
ALTER TABLE demo ADD checkbox_ms VARCHAR(512) DEFAULT NULL COMMENT 'Multistate Checkbox' AFTER radio;
ALTER TABLE demo ADD option_code CHAR(2) DEFAULT NULL COMMENT 'Multistate Checkbox' AFTER checkbox_ms;
ALTER TABLE demo ADD option_sn VARCHAR(32) DEFAULT NULL COMMENT 'Multistate Checkbox' AFTER option_code;

CREATE OR REPLACE VIEW entity_internal_external as SELECT IF(is_lib=0,'External','Internal') as entity ,count(*) as total_count FROM entity GROUP BY is_lib;


CREATE OR REPLACE VIEW internal_entity_count as SELECT(SELECT sn FROM entity WHERE code= entity_code) as entity ,count(*) as total_count FROM entity_attribute  GROUP BY entity_code;

CREATE OR REPLACE VIEW session_by_date as SELECT date_format(timestamp_punch,'%Y-%m-%d') as date,count(*) as total_count FROM sys_log GROUP BY date_format(timestamp_punch,'%Y-%m-%d');

CREATE OR REPLACE VIEW user_session_30_days as  SELECT get_user_internal_name(user_id) as user_name, count(*) as total_count FROM sys_log WHERE timestamp_punch > now() - INTERVAL 30 day GROUP BY user_id;

CREATE OR REPLACE VIEW user_engine_sessions as SELECT  get_user_internal_name(id) as user_name, (SELECT count(*) FROM sys_log WHERE action_type='DVEW' AND user_id=user_info.id ) as desk, (SELECT count(*) FROM sys_log WHERE action_type='FVEW' AND user_id=user_info.id ) as form FROM user_info;
