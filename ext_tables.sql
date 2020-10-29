CREATE TABLE tx_bssevents_domain_model_event (

        uid int(11) NOT NULL auto_increment,
        pid int(11) DEFAULT '0' NOT NULL,

        title VARCHAR(255) DEFAULT '' NOT NULL,
        place VARCHAR(255) DEFAULT '',
        organizer VARCHAR(255) DEFAULT '',
        body TEXT,

        state VARCHAR(255) DEFAULT '' NOT NULL,
        creator_uid int(11) DEFAULT '0' NOT NULL,

        categories int(11) DEFAULT '0' NOT NULL,
        appointments int(11) DEFAULT '0' NOT NULL,
        image int(11) unsigned DEFAULT '0' NOT NULL,

        tstamp int(11) unsigned DEFAULT '0' NOT NULL,
        crdate int(11) unsigned DEFAULT '0' NOT NULL,
        cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
        deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
        hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
        starttime int(11) unsigned DEFAULT '0' NOT NULL,
        endtime int(11) unsigned DEFAULT '0' NOT NULL,

        sys_language_uid int(11) DEFAULT '0' NOT NULL,
        l10n_parent int(11) DEFAULT '0' NOT NULL,
        l10n_diffsource mediumblob,

        PRIMARY KEY (uid),
        KEY parent (pid),
        KEY language (l10n_parent,sys_language_uid)
);

CREATE TABLE tx_bssevents_domain_model_category (

        uid int(11) NOT NULL auto_increment,
        pid int(11) DEFAULT '0' NOT NULL,

        title VARCHAR(255) DEFAULT '' NOT NULL,
        color VARCHAR(255) DEFAULT '' NOT NULL,

        tstamp int(11) unsigned DEFAULT '0' NOT NULL,
        crdate int(11) unsigned DEFAULT '0' NOT NULL,
        cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
        deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
        hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
        starttime int(11) unsigned DEFAULT '0' NOT NULL,
        endtime int(11) unsigned DEFAULT '0' NOT NULL,

        sys_language_uid int(11) DEFAULT '0' NOT NULL,
        l10n_parent int(11) DEFAULT '0' NOT NULL,
        l10n_diffsource mediumblob,

        PRIMARY KEY (uid),
        KEY parent (pid),
        KEY language (l10n_parent,sys_language_uid)
);

CREATE TABLE tx_bssevents_domain_model_appointment (

        uid int(11) NOT NULL auto_increment,
        pid int(11) DEFAULT '0' NOT NULL,

        date_from int(11) unsigned DEFAULT '0' NOT NULL,
        date_to int(11) unsigned DEFAULT '0' NOT NULL,
        state VARCHAR(255) DEFAULT '' NOT NULL,

        subscribers int(11) DEFAULT '0' NOT NULL,
        event int(11) DEFAULT '0' NOT NULL,
        registration int(11) DEFAULT '0' NOT NULL,
        repeat_weekly TINYINT(1) DEFAULT 0 NOT NULL,
        active TINYINT(1) DEFAULT 1 NOT NULL,
        files int(11) unsigned DEFAULT '0',


        parent int(11) DEFAULT '0' NOT NULL,
        childs int(11) DEFAULT '0' NOT NULL,

        tstamp int(11) unsigned DEFAULT '0' NOT NULL,
        crdate int(11) unsigned DEFAULT '0' NOT NULL,
        cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
        deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
        hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
        starttime int(11) unsigned DEFAULT '0' NOT NULL,
        endtime int(11) unsigned DEFAULT '0' NOT NULL,

        PRIMARY KEY (uid),
        KEY parent (pid)
);


CREATE TABLE tx_bssevents_domain_model_eventoption (

        uid int(11) NOT NULL auto_increment,
        pid int(11) DEFAULT '0' NOT NULL,

        title VARCHAR(255) DEFAULT '' NOT NULL,
        type VARCHAR(255) DEFAULT '' NOT NULL,
        `values` TEXT DEFAULT '' NOT NULL,
        selection TEXT DEFAULT '' NOT NULL,

        tstamp int(11) unsigned DEFAULT '0' NOT NULL,
        crdate int(11) unsigned DEFAULT '0' NOT NULL,
        cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
        deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
        hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
        starttime int(11) unsigned DEFAULT '0' NOT NULL,
        endtime int(11) unsigned DEFAULT '0' NOT NULL,

        sys_language_uid int(11) DEFAULT '0' NOT NULL,
        l10n_parent int(11) DEFAULT '0' NOT NULL,
        l10n_diffsource mediumblob,

        PRIMARY KEY (uid),
        KEY parent (pid),
        KEY language (l10n_parent,sys_language_uid)
);

CREATE TABLE tx_bssevents_domain_model_registration (

        uid int(11) NOT NULL auto_increment,
        pid int(11) DEFAULT '0' NOT NULL,

        public TINYINT(1) DEFAULT 0 NOT NULL,
        close TINYINT(1) DEFAULT 0 NOT NULL,
        message VARCHAR(255) DEFAULT '' NOT NULL,
        slots VARCHAR(10) DEFAULT '0' NOT NULL,

        appointment int(11) DEFAULT '0' NOT NULL,

        tstamp int(11) unsigned DEFAULT '0' NOT NULL,
        crdate int(11) unsigned DEFAULT '0' NOT NULL,
        cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
        deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
        hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
        starttime int(11) unsigned DEFAULT '0' NOT NULL,
        endtime int(11) unsigned DEFAULT '0' NOT NULL,

        PRIMARY KEY (uid),
        KEY parent (pid)
);

CREATE TABLE tx_bssevents_domain_model_subscriber (

        uid int(11) NOT NULL auto_increment,
        pid int(11) DEFAULT '0' NOT NULL,

        firstname VARCHAR(255) DEFAULT '' NOT NULL,
        lastname VARCHAR(255) DEFAULT '' NOT NULL,
        email VARCHAR(255) DEFAULT '' NOT NULL,
        phone VARCHAR(255) DEFAULT '' NOT NULL,
        street VARCHAR(255) DEFAULT '' NOT NULL,
        zip VARCHAR(255) DEFAULT '' NOT NULL,
        city VARCHAR(255) DEFAULT '' NOT NULL,
        message TEXT DEFAULT '' NOT NULL,

        appointment int(11) DEFAULT '0' NOT NULL,
        creator int(11) DEFAULT '0' NOT NULL,

        tstamp int(11) unsigned DEFAULT '0' NOT NULL,
        crdate int(11) unsigned DEFAULT '0' NOT NULL,
        cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
        deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
        hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
        starttime int(11) unsigned DEFAULT '0' NOT NULL,
        endtime int(11) unsigned DEFAULT '0' NOT NULL,

        PRIMARY KEY (uid),
        KEY parent (pid)
);

CREATE TABLE tx_bssevents_event_category_mm (
        uid_local int(11) unsigned DEFAULT '0' NOT NULL,
        uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
        sorting int(11) unsigned DEFAULT '0' NOT NULL,
        sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

        KEY uid_local (uid_local),
        KEY uid_foreign (uid_foreign)
);