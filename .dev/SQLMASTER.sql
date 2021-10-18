# SET config DB 
CREATE SCHEMA `config` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `config`;
CREATE TABLE `__cfg_api` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `allow_signup` tinyint(1) DEFAULT NULL,
  `allow_signin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
INSERT INTO config.__cfg_api
(allow_signup, allow_signin) VALUES (1,1);

CREATE TABLE `__cfg_apps` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
INSERT INTO config.__cfg_apps
(active) VALUES (1);

# SET session DB 
CREATE SCHEMA `session` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `session`;
CREATE TABLE `applications` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `accountNo` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `appID` int DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `public_username` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `applicationToken` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `finished` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `accounts` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `accountNo` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `public_accountNo` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `appID` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `permission` int DEFAULT NULL,
  `public_username` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `application_id` int DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `accounts_dates` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `account_id` int DEFAULT NULL,
  `accountNo` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `account_application_date` int DEFAULT NULL,
  `account_application_update_date` int DEFAULT NULL,
  `account_creation_date` int DEFAULT NULL,
  `account_verification_date` int DEFAULT NULL,
  `account_info_update_date` int DEFAULT NULL,
  `account_email_update_date` int DEFAULT NULL,
  `account_password_update_date` int DEFAULT NULL,
  `account_status_update_date` int DEFAULT NULL,
  `account_type_update_date` int DEFAULT NULL,
  `account_permission_update_date` int DEFAULT NULL,
  `account_last_login` int DEFAULT NULL,
  `user_data_update_date` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `users` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `account_id` int DEFAULT NULL,
  `accountNo` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `person_title` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `DOB` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone_work` varchar(45) DEFAULT NULL,
  `phone_mobile` varchar(45) DEFAULT NULL,
  `phone_home` varchar(45) DEFAULT NULL,
  `postCode` varchar(45) DEFAULT NULL,
  `address1` varchar(45) DEFAULT NULL,
  `address2` varchar(45) DEFAULT NULL,
  `address3` varchar(45) DEFAULT NULL,
  `address4` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `nationality` varchar(45) DEFAULT NULL,
  `occupation` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `session`.`__account_type` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `active` TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
INSERT INTO __account_type
(name, description, active) VALUES
('Test', 'Limited account for minor testing',0),
('Free', 'Free account with no payment options',1),
('Premium', 'Payed account',0);

CREATE TABLE `__account_status` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `active` TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
INSERT INTO __account_status
(name, description, active) VALUES
('Active', 'Green', 1),
('Pre-activation', 'Blue', 1),
('Application', 'Orange', 1),
('Closed', 'Silver', 1),
('Under investigation', 'RED', 1);


USE `session`;
DROP procedure IF EXISTS `signup_application`;

USE `session`;
DROP procedure IF EXISTS `session`.`signup_application`;
;

DELIMITER $$
USE `session`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `signup_application`(IN in_email VARCHAR(100),
																IN in_password VARCHAR(100),
                                                                IN in_public_username VARCHAR(50),
                                                                IN in_app_ID VARCHAR(5)
    )
    
BEGIN

signup_block:BEGIN

-- LOG INIT

SET @params_in = (SELECT JSON_OBJECT(
	'in_email', in_email, 'in_public_username', in_public_username, 'in_app_ID', in_app_ID
));

SET @log_accountNo = NULL;

-- CHECKING IF THE SIGNUP IS AVAILABLE
SET @signupAvailable = (
	SELECT 
		allow_signup
	FROM config.__cfg_api
);
    
IF @signupAvailable = 0 THEN
	SELECT 'ERR_MYSQL_APPLICATION_SIGNUP_DISABLED' AS '_err';
	SET @log_type = 1;
	-- ERR_SIGNUP_ST1_DB_SIGNUP_DISABLED
    
	-- LOG
	SET @params_out = (SELECT JSON_OBJECT(
		'_err', 'ERR_MYSQL_APPLICATION_SIGNUP_DISABLED'
	));  
                
	LEAVE signup_block;
END IF;

-- CHECKING IF THE REQUESTED APP IS VALID
SET @appTarget = (
	SELECT 
		COUNT(ID) 
	FROM config.__cfg_apps
	WHERE
		ID = in_app_ID
		AND active = 1
);

IF @appTarget = 0 THEN
	SELECT 'ERR_MYSQL_APPLICATION_REQUESTED_APP_NOT_AVAILABLE' AS '_err';
	SET @log_type = 2;
	-- ERR_SIGNUP_ST1_DB_REQUESTED_APP_NOT_AVAILABLE
    
	-- LOG
	SET @params_out = (SELECT JSON_OBJECT(
		'_err', 'ERR_MYSQL_APPLICATION_REQUESTED_APP_NOT_AVAILABLE'
	));
	
	LEAVE signup_block;
END IF;

	SET @nTargets = (
		SELECT 
			COUNT(ID) 
		FROM session.applications
		WHERE
			email = in_email
	);
 
	SET @new_account_number = (SELECT SUBSTRING(ROUND(UNIX_TIMESTAMP(NOW(3)) * 1000),-10));
	-- SET @new_account_public_number = (SELECT SUBSTRING(ROUND(UNIX_TIMESTAMP(NOW(3)) * 1000),1,10));
	SET @date_created = (SELECT UNIX_TIMESTAMP());
	SET @random_application_token = (SELECT SUBSTRING(MD5(RAND()),1,20));
	
	IF @nTargets = 0 THEN

		-- SESSION CREATION
		INSERT INTO session.applications
			(accountNo,
			email,
			password,
			public_username,
			applicationToken,
			finished,
            appID
			)
		VALUES
			(@new_account_number,
			in_email,
			SHA2(in_password, 256),
			in_public_username,
			@random_application_token,
			0,
            in_app_ID);
			
		-- SET @log_accountID = (SELECT ID FROM session.accounts WHERE email = in_email);
			
		-- DATE CREATION
		INSERT INTO session.accounts_dates
			(
                accountNo,
				account_application_date
			)
		VALUES
			(
                @new_account_number,
				@date_created
			);
			
		SELECT
			@random_application_token AS 'applicationToken',
			'200' AS '_code'; 
			SET @log_type = 3;
            
			-- LOG
			SET @params_out = (SELECT JSON_OBJECT(
				'_code', '200', 'applicationToken', @random_application_token
			));
                    
			LEAVE signup_block;
            
	ELSEIF @nTargets = 1 THEN
		-- CHECK IF THE ACCOUNT IS FINISHED
		SET @account_finished = (SELECT finished FROM session.applications WHERE email = in_email);
		
		IF @account_finished = 1 THEN
		
			SELECT 'ERR_MYSQL_APPLICATION_DUPLICATED_ALREADY_FINISHED' AS '_err';
			SET @log_type = 4;
            -- ERR_SIGNUP_ST1_DB_APPLICATION_ALREADY_FINISHED
            
			-- LOG
			-- SET @finished_accID = (SELECT ID FROM session.accounts WHERE email = in_email);
			SET @params_out = (SELECT JSON_OBJECT(
				'err', 'ERR_MYSQL_APPLICATION_DUPLICATED_ALREADY_FINISHED'
			));
                    
            LEAVE signup_block;
		
		ELSE
		   
			-- SESSION CREATION
			UPDATE
				session.applications
			SET 
				applicationToken = @random_application_token,
				password = SHA2(in_password, 256),
				public_username = in_public_username
			
			WHERE email = in_email;
            
			SET @log_accountNo = (SELECT AccountNo FROM session.applications WHERE email = in_email);
			UPDATE 
				session.accounts_dates
			SET
				account_application_update_date = @date_created
			WHERE
				accountNo = @log_accountNo;
			
			SELECT
				@random_application_token AS 'applicationToken',
				'200' AS '_code'; 
				SET @log_type = 5;
                
				-- LOG
				SET @params_out = (SELECT JSON_OBJECT(
					'_code', '200', 'applicationToken', @random_application_token
				));
                        
			LEAVE signup_block;
	
		END IF;
	
	ELSE
		
		SELECT 'ERR_MYSQL_APPLICATION_DUPLICATED_RECORDS_ERROR' AS '_err';
		SET @log_type = 6;
        -- ERR_SIGNUP_ST1_DB_APPLICATION_DUPLICATED_RECORDS_ERROR
        
		-- LOG
		SET @params_out = (SELECT JSON_OBJECT(
			'_err', 'ERR_MYSQL_APPLICATION_DUPLICATED_RECORDS_ERROR'
		));

		LEAVE signup_block;
        
	END IF;

END signup_block;

CALL SysLog.log_application(@log_accountNo, @log_type, @params_in, @params_out);
-- END LOG

END$$

DELIMITER ;
;



USE `session`;
DROP procedure IF EXISTS `signup_account`;

USE `session`;
DROP procedure IF EXISTS `session`.`signup_account`;
;

DELIMITER $$
USE `session`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `signup_account`(IN in_email VARCHAR(100),
																IN in_first_name VARCHAR(100),
                                                                IN in_last_name VARCHAR(100),
                                                                IN in_DOB VARCHAR(10),
                                                                IN in_applicationToken VARCHAR(20),
                                                                IN in_app_ID VARCHAR(5)
    )
BEGIN

signup_block:BEGIN

-- LOG INIT

SET @params_in = (SELECT JSON_OBJECT(
	'in_email', in_email, 
    'in_first_name', in_first_name, 
    'in_last_name', in_last_name,
	'in_DOB', in_DOB, 
    'in_applicationToken', in_applicationToken, 
    'in_app_ID', in_app_ID
));

SET @log_accountNo = NULL;

-- CHECKING IF THE SIGNUP IS AVAILABLE
SET @signupAvailable = (
	SELECT 
		allow_signup
	FROM config.__cfg_api
);
    
IF @signupAvailable = 0 THEN
	SELECT 'ERR_MYSQL_ACCOUNT_SIGNUP_DISABLED' AS '_err';
	SET @log_type = 7;
	-- ERR_SIGNUP_ST1_DB_SIGNUP_DISABLED
    
	-- LOG
	SET @params_out = (SELECT JSON_OBJECT(
		'_err', 'ERR_MYSQL_ACCOUNT_SIGNUP_DISABLED'
	));  
                
	LEAVE signup_block;
END IF;

-- CHECKING IF THE REQUESTED APP IS VALID
SET @appTarget = (
	SELECT 
		COUNT(ID) 
	FROM config.__cfg_apps
	WHERE
		ID = in_app_ID
		AND active = 1
);

IF @appTarget = 0 THEN
	SELECT 'ERR_MYSQL_ACCOUNT_REQUESTED_APP_NOT_AVAILABLE' AS '_err';
	SET @log_type = 8;
	-- ERR_SIGNUP_ST1_DB_REQUESTED_APP_NOT_AVAILABLE
    
	-- LOG
	SET @params_out = (SELECT JSON_OBJECT(
		'_err', 'ERR_MYSQL_ACCOUNT_REQUESTED_APP_NOT_AVAILABLE'
	));
	
	LEAVE signup_block;
END IF;



SET @application_ID = (
	SELECT 
		ID 
	FROM session.applications
	WHERE
		email = in_email
		AND applicationToken = in_applicationToken
);
    
IF @application_ID IS NULL THEN
	SELECT 'ERR_MYSQL_ACCOUNT_SESSIONTOKEN_FAILED' AS '_err';
	SET @log_type = 9;
	-- ERR_SIGNUP_ST1_DB_REQUESTED_APP_NOT_AVAILABLE
    
	-- LOG
	SET @params_out = (SELECT JSON_OBJECT(
		'_err', 'ERR_MYSQL_ACCOUNT_SESSIONTOKEN_FAILED'
	));
	
	LEAVE signup_block;
END IF;

SET @application_finished = (
	SELECT 
		finished
	FROM session.applications
	WHERE
		email = in_email
);
    
IF @application_finished = 1 THEN
	SELECT 'ERR_MYSQL_ACCOUNT_ALREADY_FINISHED' AS '_err';
	SET @log_type = 10;
	-- ERR_SIGNUP_ST1_DB_REQUESTED_APP_NOT_AVAILABLE
    
	-- LOG
	SET @params_out = (SELECT JSON_OBJECT(
		'_err', 'ERR_MYSQL_ACCOUNT_ALREADY_FINISHED'
	));
	
	LEAVE signup_block;
END IF;


	SET @nTargets = (
		SELECT 
			COUNT(ID) 
		FROM session.accounts
		WHERE
			email = in_email
	);
 
	SET @account_number = (SELECT accountNo FROM session.applications WHERE email = in_email);
    SET @application_id = (SELECT ID FROM session.applications WHERE email = in_email);
	SET @new_account_public_number = (SELECT SUBSTRING(ROUND(UNIX_TIMESTAMP(NOW(3)) * 1000),1,10));
	SET @date_created = (SELECT UNIX_TIMESTAMP());
    
    SET @passw = (SELECT password FROM session.applications WHERE email = in_email);
    SET @public_username = (SELECT public_username FROM session.applications WHERE email = in_email);
	
	IF @nTargets = 0 THEN

		-- SESSION CREATION
		INSERT INTO session.accounts
			(accountNo,
			public_accountNo,
			email,
			password,
			public_username,
			application_id,
            permission,
            appID,
            status,
            type,
            active,
            verified
			)
		VALUES
			(@account_number,
            @new_account_public_number,
			in_email,
			@passw,
			@public_username,
            @application_id,
			2,
            in_app_ID,
			2,
            2,
            1,
            0);
            
		SET @accountID = (SELECT ID FROM session.accounts WHERE email = in_email);
            
		INSERT INTO session.users
			(account_id,
			accountNo,
			first_name,
			last_name,
			DOB,
			email)
		VALUES
			(@accountID,
            @account_number,
            in_first_name,
            in_last_name,
            in_DOB,
            in_email);
				
		-- SET @log_accountID = (SELECT ID FROM session.accounts WHERE email = in_email);
			
		-- DATE CREATION
        SET @acc_id = (SELECT ID FROM session.accounts WHERE email = in_email);
		UPDATE session.accounts_dates
			SET account_id = @acc_id,
            account_creation_date = @date_created
		WHERE accountNo = @account_number; 
        
		UPDATE session.applications
			SET applicationToken = NULL,
            password = NULL,
            finished = 1
		WHERE email = in_email; 
			
		SET @pass = (SELECT password FROM session.accounts WHERE email = in_email);
        
		CALL session.login_account(in_email,@pass,in_app_ID,1); 
        
		LEAVE signup_block;
            		
	ELSEIF  @nTargets = 1 THEN
		                           
		SELECT 'ERR_MYSQL_ACCOUNT_ALREADY_REGISTERED' AS '_err';
			SET @log_type = 10;
			-- ERR_SIGNUP_ST1_DB_APPLICATION_DUPLICATED_RECORDS_ERROR
			
			-- LOG
			SET @params_out = (SELECT JSON_OBJECT(
				'_err', 'ERR_MYSQL_ACCOUNT_ALREADY_REGISTERED'
			));

			LEAVE signup_block;
            
	ELSE
    
		SELECT 'ERR_MYSQL_ACCOUNT_DUPLICATED_ERROR' AS '_err';
			SET @log_type = 11;
			-- ERR_SIGNUP_ST1_DB_APPLICATION_DUPLICATED_RECORDS_ERROR
			
			-- LOG
			SET @params_out = (SELECT JSON_OBJECT(
				'_err', 'ERR_MYSQL_ACCOUNT_DUPLICATED_ERROR'
			));

			LEAVE signup_block;
            
	END IF;
	
END signup_block;

CALL SysLog.log_account(@log_accountNo, @log_type, @params_in, @params_out);
-- END LOG

END$$

DELIMITER ;
;






USE `session`;
DROP procedure IF EXISTS `login_account`;

USE `session`;
DROP procedure IF EXISTS `session`.`login_account`;
;

DELIMITER $$
USE `session`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `login_account`(
												IN in_email VARCHAR(100),
												IN in_password VARCHAR(500),
                                                IN in_app_id INT,
                                                IN in_injection TINYINT(1)
)
BEGIN

session_block:BEGIN

-- LOG
SET @params_in = (SELECT JSON_OBJECT(
	'in_email', in_email, 'in_app_id', in_app_id
));

SET @log_accountID = NULL;
    
	-- CHECKING IF THE LOGIN IS AVAILABLE
	SET @loginAvailable = (
		SELECT 
			allow_signin
		FROM config.__cfg_api
    );
    
    IF @loginAvailable = 0 THEN
		SELECT 'ERR_MYSQL_LOGIN_SIGNIN_DISABLED' AS '_err';
		SET @log_type = 23;
        -- ERR_LOGIN_DB_LOGIN_DISABLED
				-- LOG
				SET @params_out = (SELECT JSON_OBJECT(
					'_err', 'ERR_MYSQL_LOGIN_SIGNIN_DISABLED'
				));
        LEAVE session_block;
	END IF;   
        
	DROP TEMPORARY TABLE IF EXISTS tmp_targets;
    CREATE TEMPORARY TABLE tmp_targets(
		SELECT
			ID,
            appID,
            active,
            password,
			accountNo,
			public_accountNo,
			email,
			status,
			permission,
			type,
			public_username
            
		FROM session.accounts
		WHERE
			email = in_email
    );
        
	SET @nTargets = (
		SELECT 
			COUNT(ID) 
		FROM tmp_targets
	);
		
	IF @nTargets > 1 THEN
		SELECT 'ERR_MYSQL_LOGIN_DUPLICATED_MAIL' AS '_err';
		SET @log_type = 24;
        -- ERR_SIGNUP_ST2_DB_APPLICATION_DUPLICATED_RECORDS_ERROR
				-- LOG
				SET @params_out = (SELECT JSON_OBJECT(
					'_err', 'ERR_MYSQL_LOGIN_DUPLICATED_MAIL'
				));        
		LEAVE session_block;
    
	ELSEIF @nTargets = 0 THEN
		SELECT 'ERR_MYSQL_LOGIN_EMAIL_DOES_NOT_EXIST' AS '_err';
		SET @log_type = 25;
        -- ERR_SIGNUP_ST2_DB_APPLICATION_DUPLICATED_RECORDS_ERROR
				-- LOG
				SET @params_out = (SELECT JSON_OBJECT(
					'_err', 'ERR_MYSQL_LOGIN_EMAIL_DOES_NOT_EXIST'
				));        
		LEAVE session_block;
	
    ELSE
    -- SHA2(in_password, 256)
		SET @log_accountID = (SELECT ID FROM tmp_targets);
		SET @acc_password = (SELECT password FROM tmp_targets);
		SET @acc_active = (SELECT active FROM tmp_targets);
        SET @acc_app_requested = (SELECT appID FROM tmp_targets);
        SET @date_now = (SELECT UNIX_TIMESTAMP());
        
        IF(in_injection = 1) THEN
			SET @pass = in_password;
		ELSE
			SET @pass = SHA2(in_password, 256);
		END IF;
        
        IF @acc_password <> @pass THEN
			SELECT 'ERR_MYSQL_LOGIN_PASSWORD_DOES_NOT_MATCH' AS '_err';
			SET @log_type = 26;
			-- ERR_SIGNUP_ST2_DB_APPLICATION_DUPLICATED_RECORDS_ERROR
					-- LOG
					SET @params_out = (SELECT JSON_OBJECT(
						'_err', 'ERR_MYSQL_LOGIN_PASSWORD_DOES_NOT_MATCH'
					));  
                    
			LEAVE session_block;
		END IF;
        
        IF @acc_active = 0 THEN
			SELECT 'ERR_MYSQL_LOGIN_ACCOUNT_NOT_ACTIVE' AS '_err';
			SET @log_type = 27;
			-- ERR_SIGNUP_ST2_DB_APPLICATION_DUPLICATED_RECORDS_ERROR
					-- LOG
					SET @params_out = (SELECT JSON_OBJECT(
						'_err', 'ERR_MYSQL_LOGIN_ACCOUNT_NOT_ACTIVE'
					));  
			
            LEAVE session_block;
		END IF;
        
        IF @acc_app_requested  <> in_app_id THEN
			SELECT 'ERR_MYSQL_LOGIN_REQUESTED_APP_NOT_AVAILABLE' AS '_err';
			SET @log_type = 28;
			-- ERR_SIGNUP_ST2_DB_APPLICATION_DUPLICATED_RECORDS_ERROR
					-- LOG
					SET @params_out = (SELECT JSON_OBJECT(
						'_err', 'ERR_MYSQL_LOGIN_REQUESTED_APP_NOT_AVAILABLE'
					));  
			
            LEAVE session_block;
		END IF;
    
    END IF;
        		
	UPDATE 
		session.accounts_dates
	SET
		account_last_login = @date_now
	WHERE 
		account_id = @log_accountID;
			
	SELECT
		accountNo,
		public_accountNo,
		email,
		status,
		permission,
		active,
		type,
		public_username,
		'200' AS '_code'
	FROM 
		session.accounts
	WHERE 
		email = in_email;
        
	SET @log_type = 29;
		SET @params_out = (SELECT JSON_OBJECT(
			'_code', '200'
		));
	
	LEAVE session_block;
        
END session_block;

-- LOG
CALL SysLog.log_login(@log_accountID, @log_type, @params_in, @params_out);
-- END LOG
    
END$$

DELIMITER ;
;

























CREATE SCHEMA `SysLog` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `SysLog`;
CREATE TABLE `applications` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `accountNo` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `type` int DEFAULT NULL,
  `params_in` json DEFAULT NULL,
  `params_out` json DEFAULT NULL,
  `created_date` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `accounts` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `accountNo` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `type` int DEFAULT NULL,
  `params_in` json DEFAULT NULL,
  `params_out` json DEFAULT NULL,
  `created_date` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `login` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `accountNo` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `type` int DEFAULT NULL,
  `params_in` json DEFAULT NULL,
  `params_out` json DEFAULT NULL,
  `created_date` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `_log_type` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `description` text CHARACTER SET utf8 COLLATE utf8_bin,
  `response_code` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
INSERT INTO _log_type
(description, response_code) VALUES 
('Application not started due to signup disabled by api config [ST1]', '21101'),
( 'Application not started due to selected app is not available [ST1]', '21102'),
('New application started [ST1]', '200'),
('Application not started due to account has been already created [ST1]', '21103'),
( 'Application updated [ST1]', '200'),
( '[ERROR] Application not started due to account is duplicated in the DB [ST1]', '21104'),
( 'Application could not continue due to signup disabled by api config [ST1]', '21105'),
( '[ERROR] Application not started due to account is duplicated in the DB [ST2]', '21106'),
( 'Application does not exist [ST2]', '21107'),
( '[WARNING] Application attempted with FALSIFIED token', '21108'),
('Application not started due to account has been already created [ST2]', '21109'),
('Registration not finished due to failed app selected [ST2]', '21110'),
('Application finished - Account created', '200'),
('Application could not be activated due to signup disabled by api config [firstLogin]', '22101'),
('Application could not be activated due to login disabled by api config [firstLogin]', '22102'),
('[WARNING] Account could not be activated due to FALSIFIED \'finish\' token [firstLogin]', '22103'),
('[ERROR] First login aborted due to duplicated email [firstLogin]', '22104'),
('Email does not exist [FLogin]', '22105'),
('Login could not be launched due to applicationToken failed [FLogin]', '22106'),
( 'Login could not be launched due to application not finished yet [FLogin]', '22107'),
('Login could not be launched due to selected app does not match the account app [FLogin]', '22108'),
('Account finished [FLogin]', '200'),
( 'Application could not be activated due to login disabled by api config [Login]', '22201'),
( 'First login aborted due to duplicated email [Login]', '22202'),
( 'Email does not exist [Login]', '22203'),
('Password does not match [Login]', '22204'),
('Account is not active [Login]', '22205'),
('Selected app does not match the account [Login]', '22206'),
('Login finished [Login]', '200');

USE `SysLog`;
DROP procedure IF EXISTS `application`;

USE `SysLog`;
DROP procedure IF EXISTS `SysLog`.`application`;
;

DELIMITER $$
USE `SysLog`$$
CREATE DEFINER=`diglesias`@`%` PROCEDURE `log_application`(
	IN in_accountNo VARCHAR(10),
    IN in_type INT,
    IN in_params_in TEXT,
    IN in_params_out TEXT
)

BEGIN

	SET @date_now = (SELECT UNIX_TIMESTAMP());

	INSERT INTO SysLog.applications
	(
		accountNo,
		type,
        params_in,
        params_out,
        created_date
	)
	VALUES 
    (
		in_accountNo,
        in_type,
        in_params_in,
        in_params_out,
        @date_now
    );

END$$

DELIMITER ;
;

DELIMITER $$
USE `SysLog`$$
CREATE DEFINER=`diglesias`@`%` PROCEDURE `log_account`(
	IN in_accountNo VARCHAR(10),
    IN in_type INT,
    IN in_params_in TEXT,
    IN in_params_out TEXT
)

BEGIN

	SET @date_now = (SELECT UNIX_TIMESTAMP());

	INSERT INTO SysLog.accounts
	(
		accountNo,
		type,
        params_in,
        params_out,
        created_date
	)
	VALUES 
    (
		in_accountNo,
        in_type,
        in_params_in,
        in_params_out,
        @date_now
    );

END$$

DELIMITER ;
;

DELIMITER $$
USE `SysLog`$$
CREATE DEFINER=`diglesias`@`%` PROCEDURE `log_login`(
	IN in_accountNo VARCHAR(10),
    IN in_type INT,
    IN in_params_in TEXT,
    IN in_params_out TEXT
)

BEGIN

	SET @date_now = (SELECT UNIX_TIMESTAMP());

	INSERT INTO SysLog.login
	(
		accountNo,
		type,
        params_in,
        params_out,
        created_date
	)
	VALUES 
    (
		in_accountNo,
        in_type,
        in_params_in,
        in_params_out,
        @date_now
    );

END$$

DELIMITER ;
;
