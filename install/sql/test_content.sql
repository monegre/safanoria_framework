# Create langs
INSERT INTO sf_langs VALUES ('1','català','ca','es_ca');
INSERT INTO sf_langs VALUES ('2','castellano','es','es_es');
INSERT INTO sf_langs VALUES ('3','english','en','en_us');
INSERT INTO sf_langs VALUES ('4','français','fr','fr_fr');

# Create empty temp relations
INSERT INTO sf_meta_content VALUES ('1','1,2,3,4','url-1','1,2,3,4','sf_posts');
INSERT INTO sf_meta_content VALUES ('2','5,6,7,8','url-2','1,2,3,4','sf_posts');
INSERT INTO sf_meta_content VALUES ('3','9,10,11,12','url-3','1,2,3,4','sf_posts');

# Create posts
INSERT INTO sf_posts VALUES ('1','1','Title 1 (1)','Content 1 (1)','','','url-1','','','','draft','author','','','ca');
INSERT INTO sf_posts VALUES ('2','1','Title 1 (2)','Content 1 (2)','','','url-1','','','','draft','author','','','es');
INSERT INTO sf_posts VALUES ('3','1','Title 1 (3)','Content 1 (3)','','','url-1','','','','draft','author','','','en');
INSERT INTO sf_posts VALUES ('4','1','Title 1 (4)','Content 1 (4)','','','url-1','','','','draft','author','','','fr');

INSERT INTO sf_posts VALUES ('5','2','Title 2 (1)','Content 2 (1)','','','url-2','','','','draft','author','','','ca');
INSERT INTO sf_posts VALUES ('6','2','Title 2 (2)','Content 2 (2)','','','url-2','','','','draft','author','','','es');
INSERT INTO sf_posts VALUES ('7','2','Title 2 (3)','Content 2 (3)','','','url-2','','','','draft','author','','','en');
INSERT INTO sf_posts VALUES ('8','2','Title 2 (4)','Content 2 (4)','','','url-2','','','','draft','author','','','fr');

INSERT INTO sf_posts VALUES ('9','3','Title 3 (1)','Content 3 (1)','','','url-3','','','','draft','author','','','ca');
INSERT INTO sf_posts VALUES ('10','3','Title 3 (2)','Content 3 (2)','','','url-3','','','','draft','author','','','es');
INSERT INTO sf_posts VALUES ('11','3','Title 3 (3)','Content 3 (3)','','','url-3','','','','draft','author','','','en');
INSERT INTO sf_posts VALUES ('12','3','Title 3 (4)','Content 3 (4)','','','url-3','','','','draft','author','','','fr');

# Create new relations
INSERT INTO sf_meta_content VALUES ('4','1,2,3,4','url-1','1,2,3,4','sf_sections');
INSERT INTO sf_meta_content VALUES ('5','5,6,7,8','url-2','1,2,3,4','sf_sections');
INSERT INTO sf_meta_content VALUES ('6','9,10,11,12','url-3','1,2,3,4','sf_sections');

#Create sections
INSERT INTO sf_sections VALUES (1,4,'Section 1 (1)','This is section 1','section-1',0,'ca');
INSERT INTO sf_sections VALUES (2,4,'Section 1 (2)','This is section 1','section-1',0,'es');
INSERT INTO sf_sections VALUES (3,4,'Section 1 (3)','This is section 1','section-1',0,'en');
INSERT INTO sf_sections VALUES (4,4,'Section 1 (4)','This is section 1','section-1',0,'fr');

INSERT INTO sf_sections VALUES (5,5,'Section 2 (1)','This is section 2','section-2''ca');
INSERT INTO sf_sections VALUES (6,5,'Section 2 (2)','This is section 2','section-2''es');
INSERT INTO sf_sections VALUES (7,5,'Section 2 (3)','This is section 2','section-2''en');
INSERT INTO sf_sections VALUES (8,5,'Section 2 (4)','This is section 2','section-2''fr');

INSERT INTO sf_sections VALUES (9,6,'Section 3 (1)','This is section 3','section-3''ca');
INSERT INTO sf_sections VALUES (10,6,'Section 3 (2)','This is section 3','section-3''es');
INSERT INTO sf_sections VALUES (11,6,'Section 3 (3)','This is section 3','section-3''en');
INSERT INTO sf_sections VALUES (12,6,'Section 3 (4)','This is section 3','section-3''fr');



