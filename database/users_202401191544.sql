INSERT INTO public.users ("name",email,"password","role",is_active,remember_token,created_at,updated_at) VALUES
	 ('admin','admin@test.com','$2y$12$stGH/vGz0vsLTNEwSc3vUemAwKr27lwMa9fFCUWldSUaWZj/yfiMO',0,1,NULL,'2024-01-19 08:08:32','2024-01-19 08:08:32'),
	 ('advertiser1','advertiser1@test.com','$2y$12$DlWhsRR7CIYY3hqW3vkw7OUpuGWr1J4nbUlBn/5/Rr9Eoz0NrHhi2',1,1,NULL,'2024-01-19 08:55:14','2024-01-19 08:55:14'),
	 ('advertiser2','advertiser2@test.com','$2y$12$td4mo4tVulUaQwyAJPgoVO1HXXzIixaB6WknQF2feo9R/2liEhq5.',1,1,NULL,'2024-01-19 09:20:13','2024-01-19 09:20:13'),
	 ('webmaster1','webmaster1@test.com','$2y$12$3NYEGoJTMQrOREaCMBHiZuX67CBlul251KCiODWDKu.wAXTF4recO',2,1,'Uh2uJ56b0K9ZPaRGU96TkTzs8wbrIe6vUvpgobSZeZlIpTmWuTXSwQtOq70S','2024-01-19 08:59:08','2024-01-19 08:59:08'),
	 ('webmaster2','webmaster2@test.com','$2y$12$pt/S6LGCwjAFIY3kBv6xd.tyuyqmg9cdk.VQ39wOrSQwUvlJVxqi6',2,1,NULL,'2024-01-19 09:23:07','2024-01-19 09:23:07');
