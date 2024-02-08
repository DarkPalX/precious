-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 06, 2024 at 04:02 PM
-- Server version: 5.7.44
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webfocusprod_cms4_ecom_precious_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` enum('image','video') COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration_date` timestamp NULL DEFAULT NULL,
  `display_type` enum('float','fixed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transition_in` int(11) NOT NULL DEFAULT '1',
  `transition_out` int(11) NOT NULL DEFAULT '2',
  `transition` int(11) NOT NULL DEFAULT '6',
  `type` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sub_banner',
  `banner_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `user_id` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `name`, `transition_in`, `transition_out`, `transition`, `type`, `banner_type`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Home Banner', 43, 46, 2, 'main_banner', 'image', 1, '2024-01-30 06:25:03', '2024-02-06 03:20:45', NULL),
(2, 'Sub Banner 1', 1, 2, 6, 'sub_banner', 'image', 1, '2024-01-30 06:25:03', '2024-01-30 06:25:03', NULL),
(3, 'Sub Banner 2', 49, 56, 2, 'sub_banner', 'image', 1, '2024-02-06 03:32:26', '2024-02-06 03:32:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL DEFAULT '2024-01-30',
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contents` text COLLATE utf8mb4_unicode_ci,
  `teaser` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `is_featured` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `image_url` text COLLATE utf8mb4_unicode_ci,
  `thumbnail_url` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keyword` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `user_id` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `category_id`, `slug`, `date`, `name`, `contents`, `teaser`, `status`, `is_featured`, `image_url`, `thumbnail_url`, `meta_title`, `meta_keyword`, `meta_description`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, 'lorem-ipsum-1', '2024-01-30', 'THIS IS A STANDARD POST WITH A PREVIEW IMAGE', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'Published', '1', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/news/news1.jpg', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/news/news1.jpg', 'title', 'keyword', 'description', '1', '2024-01-30 06:25:03', '2024-01-30 06:25:03', NULL),
(2, NULL, 'lorem-ipsum-2', '2024-01-30', 'THIS IS A STANDARD POST WITH A PREVIEW IMAGE', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'Published', '1', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/news/news2.jpg', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/news/news2.jpg', 'title', 'keyword', 'description', '1', '2024-01-30 06:25:03', '2024-01-30 06:25:03', NULL),
(3, NULL, 'lorem-ipsum-3', '2024-01-30', 'THIS IS A STANDARD POST WITH A PREVIEW IMAGE', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'Published', '1', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/news/news3.jpg', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/news/news3.jpg', 'title', 'keyword', 'description', '1', '2024-01-30 06:25:03', '2024-01-30 06:25:03', NULL),
(4, NULL, 'lorem-ipsum-4', '2024-01-30', 'THIS IS A STANDARD POST WITH A PREVIEW IMAGE', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'Published', '1', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/news/news4.jpg', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/news/news4.jpg', 'title', 'keyword', 'description', '1', '2024-01-30 06:25:03', '2024-01-30 06:25:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `article_categories`
--

CREATE TABLE `article_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_categories`
--

INSERT INTO `article_categories` (`id`, `name`, `slug`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'General', 'general', 1, '2024-02-06 02:35:55', '2024-02-06 02:35:55', NULL),
(2, 'Announcements', 'announcements', 1, '2024-02-06 02:36:03', '2024-02-06 02:36:03', NULL),
(3, 'Events', 'events', 1, '2024-02-06 02:36:13', '2024-02-06 02:36:13', NULL),
(4, 'Informative', 'informative', 1, '2024-02-06 02:36:22', '2024-02-06 02:36:22', NULL),
(5, 'Test A', 'test-a', 1, '2024-02-06 03:49:24', '2024-02-06 03:49:50', '2024-02-06 03:49:50'),
(6, 'Test', 'test-2', 1, '2024-02-06 03:49:24', '2024-02-06 03:49:31', '2024-02-06 03:49:31'),
(7, 'Test', 'test-3', 1, '2024-02-06 03:49:25', '2024-02-06 03:49:28', '2024-02-06 03:49:28');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(10) UNSIGNED NOT NULL,
  `album_id` int(11) NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `alt` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_text` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `album_id`, `title`, `description`, `alt`, `image_path`, `button_text`, `url`, `order`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Welcome to Canvas', 'Create just what you need for your Perfect Website. Choose from a wide range of Elements &amp; simply put them on your own Canvas.', NULL, 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/banners/image1.jpg', 'Contact Us', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/contact-us', 1, 1, '2024-01-30 06:25:03', '2024-02-06 03:17:18', '2024-02-06 03:17:18'),
(2, 1, 'Beautifully Flexible', 'Looks beautiful &amp; ultra-sharp on Retina Screen Displays. Powerful Layout with Responsive functionality that can be adapted to any screen size.', NULL, 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/banners/videos/webfocus.webm', NULL, NULL, 2, 1, '2024-01-30 06:25:03', '2024-02-06 03:17:18', '2024-02-06 03:17:18'),
(3, 1, NULL, NULL, NULL, 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/banners/image2.jpg', NULL, NULL, 3, 1, '2024-01-30 06:25:03', '2024-02-06 03:17:18', '2024-02-06 03:17:18'),
(4, 1, 'Welcome to Canvas', 'Create just what you need for your Perfect Website. Choose from a wide range of Elements &amp; simply put them on your own Canvas.', NULL, 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/storage/banners//banner1 1163px by 669px.jpg', 'Contact Us', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/', 1, 1, '2024-02-06 03:17:05', '2024-02-06 03:17:37', NULL),
(5, 1, 'Beautifully Flexible', 'Looks beautiful &amp; ultra-sharp on Retina Screen Displays. Powerful Layout with Responsive functionality that can be adapted to any screen size.', NULL, 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/storage/banners//banner2 1163px by 669px.jpg', 'Test Button', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/about-us', 2, 1, '2024-02-06 03:17:05', '2024-02-06 03:17:18', NULL),
(6, 1, 'Great Performance', 'You\'ll be surprised to see the Final Results of your Creation & would crave for more.', NULL, 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/storage/banners//banner3 1163px by 669px.jpg', NULL, NULL, 3, 1, '2024-02-06 03:17:05', '2024-02-06 03:17:18', NULL),
(7, 1, NULL, NULL, NULL, 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/storage/banners//banner4 1163px by 669px.jpg', NULL, NULL, 4, 1, '2024-02-06 03:20:10', '2024-02-06 03:20:10', NULL),
(8, 3, NULL, NULL, NULL, 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/storage/banners//banner 5 1904x500.jpg', NULL, NULL, 1, 1, '2024-02-06 03:32:26', '2024-02-06 03:32:26', NULL),
(9, 3, NULL, NULL, NULL, 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/storage/banners//banner 6 1904x500.jpg', NULL, NULL, 2, 1, '2024-02-06 03:32:26', '2024-02-06 03:32:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_url` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_activity_logs`
--

CREATE TABLE `cms_activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dashboard_activity` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_desc` text COLLATE utf8mb4_unicode_ci,
  `activity_date` datetime DEFAULT NULL,
  `db_table` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `old_value` text COLLATE utf8mb4_unicode_ci,
  `new_value` text COLLATE utf8mb4_unicode_ci,
  `reference` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_activity_logs`
--

INSERT INTO `cms_activity_logs` (`id`, `log_by`, `activity_type`, `dashboard_activity`, `activity_desc`, `activity_date`, `db_table`, `old_value`, `new_value`, `reference`) VALUES
(1, '1', 'insert', 'created a new product category', 'created the product category Novel', '2024-02-05 15:51:38', 'product_categories', '', 'Novel', '1'),
(2, '1', 'insert', 'created a new product category', 'created the product category Comic', '2024-02-05 15:51:51', 'product_categories', '', 'Comic', '2'),
(3, '1', 'insert', 'created a new product category', 'created the product category Health', '2024-02-05 15:52:08', 'product_categories', '', 'Health', '3'),
(4, '1', 'insert', 'created a new product category', 'created the product category Educational', '2024-02-05 15:52:21', 'product_categories', '', 'Educational', '4'),
(5, '1', 'insert', 'created a new product category', 'created the product category 123', '2024-02-05 15:52:30', 'product_categories', '', '123', '5'),
(6, '1', 'delete', 'deleted a product category', 'deleted the product category 123', '2024-02-05 15:52:41', 'product_categories', '', '', '5'),
(7, '1', 'update', 'updated the user firstname', 'updated the user firstname of Admin from Admin to admin', '2024-02-05 16:02:29', 'users', 'Admin', 'admin', '1'),
(8, '1', 'update', 'updated the user lastname', 'updated the user lastname of Admin from Istrator to istrator', '2024-02-05 16:02:29', 'users', 'Istrator', 'istrator', '1'),
(9, '1', 'insert', 'uploaded a new inventory', 'uploaded the inventory ', '2024-02-05 16:05:07', 'inventory_receiver_header', '', NULL, '1'),
(10, '1', 'update', 'updated the user firstname', 'updated the user firstname of Admin from Admin to admin', '2024-02-05 16:17:41', 'users', 'Admin', 'admin', '1'),
(11, '1', 'update', 'updated the user lastname', 'updated the user lastname of Admin from Istrator to istrator', '2024-02-05 16:17:41', 'users', 'Istrator', 'istrator', '1'),
(12, '1', 'update', 'updated the user firstname', 'updated the user firstname of Admin from Admin to admin', '2024-02-06 09:14:38', 'users', 'Admin', 'admin', '1'),
(13, '1', 'update', 'updated the user lastname', 'updated the user lastname of Admin from Istrator to istrator', '2024-02-06 09:14:38', 'users', 'Istrator', 'istrator', '1'),
(14, '1', 'update', 'updated the page contents', 'updated the page contents of Home from <div class=\"container topmargin-lg bottommargin-lg\"><div class=\"row\"><div class=\"col-md-5\" id=\"iazs\"><div class=\"heading-block border-bottom-0\"><h1>Welcome to our website!</h1></div><p class=\"lead\">Integer luctus, odio sit amet ultricies feugiat, urna massa suscipit lectus, vel eleifend justo libero et ex.</p><blockquote id=\"iqfa\">\r\n                            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc semper tortor in nulla fermentum imperdiet.\r\n                        </blockquote><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/about-us\" id=\"itiaj\" class=\"btn bg-color text-white\">Read more about us</a><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/books\" id=\"ir0xp\" class=\"btn bg-color text-white\">See all our books</a></div><div class=\"col-md-7 align-self-end\"><div class=\"position-relative overflow-hidden\"><img src=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/misc/devices.png\" data-animate=\"fadeInUp\" data-delay=\"100\" alt=\"Chrome\"/></div></div></div></div><div class=\"section dark my-0\" id=\"img4v\"><div class=\"container\"><div class=\"heading-block center border-bottom-0\"><h3>Featured Books</h3></div><div id=\"oc-portfolio\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"4\" class=\"owl-carousel portfolio-carousel carousel-widget\">\r\n                        {Featured Products}\r\n                    </div><div class=\"text-center m-auto w-75\"><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/books\" id=\"i3hto\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a></div></div></div><div class=\"section my-0\"><div class=\"container\"><div class=\"heading-block center border-bottom-0\"><h3>Best Sellers</h3></div><div id=\"oc-portfolio-2\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"5\" class=\"owl-carousel portfolio-carousel carousel-widget\">\r\n                        {Best Sellers}\r\n                    </div><div class=\"text-center m-auto w-75\"><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/books\" id=\"i3i2i\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a></div></div></div><div class=\"section my-0\" id=\"i2d05\"><div class=\"container\" id=\"ihifs\"><div class=\"heading-block center border-bottom-0\"><h3>New Releases</h3></div><div id=\"oc-portfolio-3\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"5\" class=\"owl-carousel portfolio-carousel carousel-widget\">\r\n                        {New Releases}\r\n                    </div><div class=\"text-center m-auto w-75\"><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/books\" id=\"iea9c\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a></div></div></div><div class=\"section my-0\"><div class=\"container\" id=\"id5th\"><div class=\"heading-block center\"><h3>Latest News</h3></div><div id=\"oc-posts\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-lg=\"4\" class=\"owl-carousel posts-carousel carousel-widget posts-md\">\r\n                        {Featured Articles}\r\n                    </div><div class=\"text-center m-auto w-75\"><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/news\" id=\"izfmr\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">Read More</a></div></div></div> to \n            <div class=\"container topmargin-lg bottommargin-lg\">\n                <div class=\"row\">\n                    <div class=\"col-md-5\">\n                        <div class=\"heading-block border-bottom-0\">\n                            <h1>Welcome to our website!</h1>\n                        </div>\n                        <p class=\"lead\">Integer luctus, odio sit amet ultricies feugiat, urna massa suscipit lectus, vel eleifend justo libero et ex.</p>\n\n                        <blockquote>\n                            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc semper tortor in nulla fermentum imperdiet.\n                        </blockquote>\n                        \n                        <a href=\"about.htm\" class=\"btn bg-color text-white\">Read more about us</a>\n                        <a href=\"books.htm\" class=\"btn bg-color text-white\">See all our books</a>\n                    </div>\n\n                    <div class=\"col-md-7 align-self-end\">\n                        <div class=\"position-relative overflow-hidden\">\n                            <img src=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/misc/devices.png\" data-animate=\"fadeInUp\" data-delay=\"100\" alt=\"Chrome\">\n                        </div>\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"section dark my-0\" style=\"background-color:#21395f;\">\n                <div class=\"container\">\n                    <div class=\"heading-block center border-bottom-0\">\n                        <h3>Featured Books</h3>\n                    </div>\n                    \n                    <div id=\"oc-portfolio\" class=\"owl-carousel portfolio-carousel carousel-widget\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"4\">\n                        {Featured Products}\n                    </div>\n                    \n                    <div class=\"text-center m-auto w-75\">                   \n                        <a href=\"news.htm\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a>\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"section my-0\">\n                <div class=\"container\">\n                    <div class=\"heading-block center border-bottom-0\">\n                        <h3>Best Sellers</h3>\n                    </div>\n                    \n                    <div id=\"oc-portfolio\" class=\"owl-carousel portfolio-carousel carousel-widget\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"5\">\n                        {Best Sellers}\n                    </div>\n                    \n                    <div class=\"text-center m-auto w-75\">                   \n                        <a href=\"books.htm\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a>\n                    </div>\n                </div>\n            </div>\n\n\n            <div class=\"section my-0\" style=\"background-color:white;\">\n                <div class=\"container\">\n                    <div class=\"heading-block center border-bottom-0\">\n                        <h3>New Releases</h3>\n                    </div>\n                    \n                    <div id=\"oc-portfolio\" class=\"owl-carousel portfolio-carousel carousel-widget\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"5\">\n                        {New Releases}\n                    </div>\n                    \n                    <div class=\"text-center m-auto w-75\">                   \n                        <a href=\"books.htm\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a>\n                    </div>\n                </div>\n            </div>\n\n\n            <div class=\"section my-0\">\n                <div class=\"container\">\n                    <div class=\"heading-block center\">\n                        <h3>Latest News</h3>\n                    </div>\n\n                    <div id=\"oc-posts\" class=\"owl-carousel posts-carousel carousel-widget posts-md\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-lg=\"4\">\n                        {Featured Articles}\n                    </div>\n\n                    <div class=\"text-center m-auto w-75\">                   \n                        <a href=\"news.htm\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">Read More</a>\n                    </div>\n                </div>\n            </div>', '2024-02-06 09:20:06', 'pages', '<div class=\"container topmargin-lg bottommargin-lg\"><div class=\"row\"><div class=\"col-md-5\" id=\"iazs\"><div class=\"heading-block border-bottom-0\"><h1>Welcome to our website!</h1></div><p class=\"lead\">Integer luctus, odio sit amet ultricies feugiat, urna massa suscipit lectus, vel eleifend justo libero et ex.</p><blockquote id=\"iqfa\">\r\n                            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc semper tortor in nulla fermentum imperdiet.\r\n                        </blockquote><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/about-us\" id=\"itiaj\" class=\"btn bg-color text-white\">Read more about us</a><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/books\" id=\"ir0xp\" class=\"btn bg-color text-white\">See all our books</a></div><div class=\"col-md-7 align-self-end\"><div class=\"position-relative overflow-hidden\"><img src=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/misc/devices.png\" data-animate=\"fadeInUp\" data-delay=\"100\" alt=\"Chrome\"/></div></div></div></div><div class=\"section dark my-0\" id=\"img4v\"><div class=\"container\"><div class=\"heading-block center border-bottom-0\"><h3>Featured Books</h3></div><div id=\"oc-portfolio\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"4\" class=\"owl-carousel portfolio-carousel carousel-widget\">\r\n                        {Featured Products}\r\n                    </div><div class=\"text-center m-auto w-75\"><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/books\" id=\"i3hto\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a></div></div></div><div class=\"section my-0\"><div class=\"container\"><div class=\"heading-block center border-bottom-0\"><h3>Best Sellers</h3></div><div id=\"oc-portfolio-2\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"5\" class=\"owl-carousel portfolio-carousel carousel-widget\">\r\n                        {Best Sellers}\r\n                    </div><div class=\"text-center m-auto w-75\"><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/books\" id=\"i3i2i\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a></div></div></div><div class=\"section my-0\" id=\"i2d05\"><div class=\"container\" id=\"ihifs\"><div class=\"heading-block center border-bottom-0\"><h3>New Releases</h3></div><div id=\"oc-portfolio-3\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"5\" class=\"owl-carousel portfolio-carousel carousel-widget\">\r\n                        {New Releases}\r\n                    </div><div class=\"text-center m-auto w-75\"><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/books\" id=\"iea9c\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a></div></div></div><div class=\"section my-0\"><div class=\"container\" id=\"id5th\"><div class=\"heading-block center\"><h3>Latest News</h3></div><div id=\"oc-posts\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-lg=\"4\" class=\"owl-carousel posts-carousel carousel-widget posts-md\">\r\n                        {Featured Articles}\r\n                    </div><div class=\"text-center m-auto w-75\"><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/news\" id=\"izfmr\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">Read More</a></div></div></div>', '\n            <div class=\"container topmargin-lg bottommargin-lg\">\n                <div class=\"row\">\n                    <div class=\"col-md-5\">\n                        <div class=\"heading-block border-bottom-0\">\n                            <h1>Welcome to our website!</h1>\n                        </div>\n                        <p class=\"lead\">Integer luctus, odio sit amet ultricies feugiat, urna massa suscipit lectus, vel eleifend justo libero et ex.</p>\n\n                        <blockquote>\n                            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc semper tortor in nulla fermentum imperdiet.\n                        </blockquote>\n                        \n                        <a href=\"about.htm\" class=\"btn bg-color text-white\">Read more about us</a>\n                        <a href=\"books.htm\" class=\"btn bg-color text-white\">See all our books</a>\n                    </div>\n\n                    <div class=\"col-md-7 align-self-end\">\n                        <div class=\"position-relative overflow-hidden\">\n                            <img src=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/misc/devices.png\" data-animate=\"fadeInUp\" data-delay=\"100\" alt=\"Chrome\">\n                        </div>\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"section dark my-0\" style=\"background-color:#21395f;\">\n                <div class=\"container\">\n                    <div class=\"heading-block center border-bottom-0\">\n                        <h3>Featured Books</h3>\n                    </div>\n                    \n                    <div id=\"oc-portfolio\" class=\"owl-carousel portfolio-carousel carousel-widget\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"4\">\n                        {Featured Products}\n                    </div>\n                    \n                    <div class=\"text-center m-auto w-75\">                   \n                        <a href=\"news.htm\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a>\n                    </div>\n                </div>\n            </div>\n\n            <div class=\"section my-0\">\n                <div class=\"container\">\n                    <div class=\"heading-block center border-bottom-0\">\n                        <h3>Best Sellers</h3>\n                    </div>\n                    \n                    <div id=\"oc-portfolio\" class=\"owl-carousel portfolio-carousel carousel-widget\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"5\">\n                        {Best Sellers}\n                    </div>\n                    \n                    <div class=\"text-center m-auto w-75\">                   \n                        <a href=\"books.htm\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a>\n                    </div>\n                </div>\n            </div>\n\n\n            <div class=\"section my-0\" style=\"background-color:white;\">\n                <div class=\"container\">\n                    <div class=\"heading-block center border-bottom-0\">\n                        <h3>New Releases</h3>\n                    </div>\n                    \n                    <div id=\"oc-portfolio\" class=\"owl-carousel portfolio-carousel carousel-widget\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"5\">\n                        {New Releases}\n                    </div>\n                    \n                    <div class=\"text-center m-auto w-75\">                   \n                        <a href=\"books.htm\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a>\n                    </div>\n                </div>\n            </div>\n\n\n            <div class=\"section my-0\">\n                <div class=\"container\">\n                    <div class=\"heading-block center\">\n                        <h3>Latest News</h3>\n                    </div>\n\n                    <div id=\"oc-posts\" class=\"owl-carousel posts-carousel carousel-widget posts-md\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-lg=\"4\">\n                        {Featured Articles}\n                    </div>\n\n                    <div class=\"text-center m-auto w-75\">                   \n                        <a href=\"news.htm\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">Read More</a>\n                    </div>\n                </div>\n            </div>', '1'),
(15, '1', 'update', 'updated the menu menu order', 'updated the menu menu order of Menu 1 from [{\"label\":\"Home\",\"type\":\"page\",\"page_id\":1,\"id\":1},{\"label\":\"About Us\",\"type\":\"page\",\"page_id\":2,\"id\":2},{\"label\":\"News and Updates\",\"type\":\"page\",\"page_id\":4,\"id\":3},{\"label\":\"Contact Us\",\"type\":\"page\",\"page_id\":3}] to []', '2024-02-06 10:06:50', 'menus', '[{\"label\":\"Home\",\"type\":\"page\",\"page_id\":1,\"id\":1},{\"label\":\"About Us\",\"type\":\"page\",\"page_id\":2,\"id\":2},{\"label\":\"News and Updates\",\"type\":\"page\",\"page_id\":4,\"id\":3},{\"label\":\"Contact Us\",\"type\":\"page\",\"page_id\":3}]', '[]', '1'),
(16, '1', 'update', 'updated the banner button text', 'updated the banner button text of  from Contact Us to ', '2024-02-06 10:08:14', 'banners', 'Contact Us', NULL, '1'),
(17, '1', 'update', 'updated the banner url', 'updated the banner url of  from https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/contact-us to https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public', '2024-02-06 10:08:14', 'banners', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/contact-us', 'https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public', '1'),
(18, '1', 'update', 'updated the banner title', 'updated the banner title of  from  to Premium Constructions', '2024-02-06 10:08:14', 'banners', NULL, 'Premium Constructions', '3'),
(19, '1', 'update', 'updated the banner description', 'updated the banner description of  from  to You\'ll be surprised to see the Final Results of your Creation &amp; would crave for more.', '2024-02-06 10:08:14', 'banners', NULL, 'You\'ll be surprised to see the Final Results of your Creation &amp; would crave for more.', '3'),
(20, '1', 'update', 'updated the settings company logo', 'updated the settings company logo of  from 1707185818_webfocus-logo.png to logo-transparent.png', '2024-02-06 10:16:58', 'settings', '1707185818_webfocus-logo.png', 'logo-transparent.png', '1'),
(21, '1', 'update', 'updated the menu menu order', 'updated the menu menu order of Menu 1 from [{\"label\":\"Home\",\"type\":\"page\",\"page_id\":1,\"id\":1},{\"label\":\"About Us\",\"type\":\"page\",\"page_id\":2,\"id\":2},{\"label\":\"Blog\",\"type\":\"page\",\"page_id\":4,\"id\":3},{\"label\":\"Contact Us\",\"type\":\"page\",\"page_id\":3,\"id\":4}] to [{\"label\":\"Home\",\"type\":\"page\",\"page_id\":1,\"id\":1},{\"label\":\"About Us\",\"type\":\"page\",\"page_id\":2,\"id\":2},{\"label\":\"News and Updates\",\"type\":\"page\",\"page_id\":4,\"id\":3},{\"label\":\"Contact Us\",\"type\":\"page\",\"page_id\":3}]', '2024-02-06 10:17:56', 'menus', '[{\"label\":\"Home\",\"type\":\"page\",\"page_id\":1,\"id\":1},{\"label\":\"About Us\",\"type\":\"page\",\"page_id\":2,\"id\":2},{\"label\":\"Blog\",\"type\":\"page\",\"page_id\":4,\"id\":3},{\"label\":\"Contact Us\",\"type\":\"page\",\"page_id\":3,\"id\":4}]', '[{\"label\":\"Home\",\"type\":\"page\",\"page_id\":1,\"id\":1},{\"label\":\"About Us\",\"type\":\"page\",\"page_id\":2,\"id\":2},{\"label\":\"News and Updates\",\"type\":\"page\",\"page_id\":4,\"id\":3},{\"label\":\"Contact Us\",\"type\":\"page\",\"page_id\":3}]', '1'),
(22, '1', 'update', 'updated the page label', 'updated the page label of News and Updates from Blog to News and Updates', '2024-02-06 10:17:56', 'pages', 'Blog', 'News and Updates', '4'),
(23, '1', 'insert', 'created a new menu', 'created the menu Test Menu', '2024-02-06 10:30:20', 'menus', '', 'Test Menu', '2'),
(24, '1', 'insert', 'created a new article category', 'created the article category General', '2024-02-06 10:35:55', 'article_categories', '', 'General', '1'),
(25, '1', 'insert', 'created a new article category', 'created the article category Announcements', '2024-02-06 10:36:03', 'article_categories', '', 'Announcements', '2'),
(26, '1', 'insert', 'created a new article category', 'created the article category Events', '2024-02-06 10:36:13', 'article_categories', '', 'Events', '3'),
(27, '1', 'insert', 'created a new article category', 'created the article category Informative', '2024-02-06 10:36:22', 'article_categories', '', 'Informative', '4'),
(28, '1', 'insert', 'created a new role', 'created the role Guest Viewer Only', '2024-02-06 10:44:17', 'role', '', 'Guest Viewer Only', '7'),
(29, '1', 'insert', 'created a new role', 'created the role News Caster', '2024-02-06 10:44:35', 'role', '', 'News Caster', '8'),
(30, '1', 'insert', 'created a new role', 'created the role Page Manager', '2024-02-06 10:44:51', 'role', '', 'Page Manager', '9'),
(31, '1', 'insert', 'created a new role', 'created the role User Manager', '2024-02-06 10:45:14', 'role', '', 'User Manager', '10'),
(32, '1', 'insert', 'created a new product category', 'created the product category Cooking', '2024-02-06 10:49:27', 'product_categories', '', 'Cooking', '6'),
(33, '1', 'insert', 'created a new product category', 'created the product category Food and Cooking', '2024-02-06 10:49:47', 'product_categories', '', 'Food and Cooking', '7'),
(34, '1', 'delete', 'deleted a product category', 'deleted the product category Cooking', '2024-02-06 10:51:42', 'product_categories', '', '', '6'),
(35, '1', 'insert', 'created a new product category', 'created the product category Romance', '2024-02-06 10:52:06', 'product_categories', '', 'Romance', '8'),
(36, '1', 'insert', 'uploaded a new inventory', 'uploaded the inventory ', '2024-02-06 10:59:18', 'inventory_receiver_header', '', NULL, '2'),
(37, '1', 'insert', 'uploaded a new inventory', 'uploaded the inventory ', '2024-02-06 10:59:26', 'inventory_receiver_header', '', NULL, '3'),
(38, '1', 'insert', 'uploaded a new inventory', 'uploaded the inventory ', '2024-02-06 10:59:37', 'inventory_receiver_header', '', NULL, '4'),
(39, '1', 'insert', 'uploaded a new inventory', 'uploaded the inventory ', '2024-02-06 10:59:48', 'inventory_receiver_header', '', NULL, '5'),
(40, '1', 'insert', 'uploaded a new inventory', 'uploaded the inventory ', '2024-02-06 11:00:02', 'inventory_receiver_header', '', NULL, '6'),
(41, '1', 'insert', 'uploaded a new inventory', 'uploaded the inventory ', '2024-02-06 11:00:15', 'inventory_receiver_header', '', NULL, '7'),
(42, '1', 'update', 'updated the banner order', 'updated the banner order of  from 1 to 4', '2024-02-06 11:17:18', 'banners', '1', '4', '4'),
(43, '1', 'update', 'updated the banner order', 'updated the banner order of  from 2 to 5', '2024-02-06 11:17:18', 'banners', '2', '5', '5'),
(44, '1', 'update', 'updated the banner order', 'updated the banner order of  from 3 to 6', '2024-02-06 11:17:18', 'banners', '3', '6', '6'),
(45, '1', 'delete', 'deleted a banner', 'deleted the banner ', '2024-02-06 11:17:18', 'banners', '', '', '1'),
(46, '1', 'delete', 'deleted a banner', 'deleted the banner ', '2024-02-06 11:17:18', 'banners', '', '', '2'),
(47, '1', 'delete', 'deleted a banner', 'deleted the banner ', '2024-02-06 11:17:18', 'banners', '', '', '3'),
(48, '1', 'update', 'updated the banner button text', 'updated the banner button text of  from Contact Us to Test Button', '2024-02-06 11:17:37', 'banners', 'Contact Us', 'Test Button', '4'),
(49, '1', 'update', 'updated the album transition-in', 'updated the album transition-in of Home Banner from 43 to 1', '2024-02-06 11:20:45', 'albums', '43', '1', '1'),
(50, '1', 'update', 'updated the album transition-out', 'updated the album transition-out of Home Banner from 46 to 2', '2024-02-06 11:20:45', 'albums', '46', '2', '1'),
(51, '1', 'update', 'updated the album transation duration', 'updated the album transation duration of Home Banner from 2 to 6', '2024-02-06 11:20:45', 'albums', '2', '6', '1'),
(52, '1', 'insert', 'created a new album', 'created the album Sub Banner 2', '2024-02-06 11:32:26', 'albums', '', 'Sub Banner 2', '3'),
(53, '1', 'delete', 'deleted a album', 'deleted the album Sub Banner 2', '2024-02-06 11:32:30', 'albums', '', '', '3'),
(54, '1', 'update', 'updated the album name', 'updated the album name of Sub Banner 2X from Sub Banner 2X to Sub Banner 2', '2024-02-06 11:32:43', 'albums', 'Sub Banner 2X', 'Sub Banner 2', '3'),
(55, '1', 'update', 'updated the album name', 'updated the album name of Sub Banner 2 from Sub Banner 2 to Sub Banner 2X', '2024-02-06 11:32:59', 'albums', 'Sub Banner 2', 'Sub Banner 2X', '3'),
(56, '1', 'update', 'updated the user firstname', 'updated the user firstname of Admin from Admin to admin', '2024-02-06 11:33:23', 'users', 'Admin', 'admin', '1'),
(57, '1', 'update', 'updated the user lastname', 'updated the user lastname of Admin from Istratorz to istrator', '2024-02-06 11:33:23', 'users', 'Istratorz', 'istrator', '1'),
(58, '1', 'update', 'updated the settings company name', 'updated the settings company name of  from PRECIOUS PAGES CORPz to PRECIOUS PAGES CORP', '2024-02-06 11:33:29', 'settings', 'PRECIOUS PAGES CORPz', 'PRECIOUS PAGES CORP', '1'),
(59, '1', 'update', 'updated the settings company name', 'updated the settings company name of  from PRECIOUS PAGES CORP to PRECIOUS PAGES CORPz', '2024-02-06 11:33:33', 'settings', 'PRECIOUS PAGES CORP', 'PRECIOUS PAGES CORPz', '1'),
(60, '1', 'update', 'updated the settings company name', 'updated the settings company name of  from PRECIOUS PAGES CORPad to PRECIOUS PAGES CORP', '2024-02-06 11:33:37', 'settings', 'PRECIOUS PAGES CORPad', 'PRECIOUS PAGES CORP', '1'),
(61, '1', 'update', 'updated the settings company name', 'updated the settings company name of  from PRECIOUS PAGES CORP to PRECIOUS PAGES CORPad', '2024-02-06 11:33:41', 'settings', 'PRECIOUS PAGES CORP', 'PRECIOUS PAGES CORPad', '1'),
(62, '1', 'insert', 'created a new article category', 'created the article category Test', '2024-02-06 11:49:24', 'article_categories', '', 'Test', '5'),
(63, '1', 'insert', 'created a new article category', 'created the article category Test', '2024-02-06 11:49:24', 'article_categories', '', 'Test', '6'),
(64, '1', 'insert', 'created a new article category', 'created the article category Test', '2024-02-06 11:49:25', 'article_categories', '', 'Test', '7'),
(65, '1', 'update', 'updated the article category name', 'updated the article category name of Test A from Test A to Test', '2024-02-06 11:49:46', 'article_categories', 'Test A', 'Test', '5'),
(66, '1', 'insert', 'uploaded a new inventory', 'uploaded the inventory ', '2024-02-06 11:52:00', 'inventory_receiver_header', '', NULL, '8'),
(67, '1', 'insert', 'uploaded a new inventory', 'uploaded the inventory ', '2024-02-06 11:52:22', 'inventory_receiver_header', '', NULL, '9'),
(68, '1', 'insert', 'uploaded a new inventory', 'uploaded the inventory ', '2024-02-06 11:52:31', 'inventory_receiver_header', '', NULL, '10'),
(69, '1', 'insert', 'uploaded a new inventory', 'uploaded the inventory ', '2024-02-06 11:56:08', 'inventory_receiver_header', '', NULL, '11');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_code` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `terms_and_conditions` text COLLATE utf8mb4_unicode_ci,
  `activation_type` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_scope` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scope_customer_id` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_discount_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_discount_amount` decimal(16,2) DEFAULT NULL,
  `amount` decimal(16,2) DEFAULT NULL,
  `percentage` int(11) DEFAULT NULL,
  `free_product_id` int(11) DEFAULT NULL,
  `status` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `repeat_annually` int(11) DEFAULT NULL,
  `purchase_product_id` text COLLATE utf8mb4_unicode_ci,
  `purchase_product_cat_id` text COLLATE utf8mb4_unicode_ci,
  `purchase_product_brand` text COLLATE utf8mb4_unicode_ci,
  `purchase_amount` decimal(16,2) DEFAULT NULL,
  `purchase_amount_type` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount_discount_type` int(11) DEFAULT '0',
  `purchase_qty` decimal(16,2) DEFAULT NULL,
  `purchase_qty_type` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_combination_counter` int(11) DEFAULT '0',
  `purchase_combination` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_type` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_limit` int(11) DEFAULT NULL,
  `usage_limit` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usage_limit_no` int(11) DEFAULT NULL,
  `combination` int(11) DEFAULT NULL,
  `availability` int(11) NOT NULL DEFAULT '0',
  `product_discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_product_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `name`, `description`, `terms_and_conditions`, `activation_type`, `customer_scope`, `scope_customer_id`, `location`, `location_discount_type`, `location_discount_amount`, `amount`, `percentage`, `free_product_id`, `status`, `start_date`, `end_date`, `start_time`, `end_time`, `event_name`, `event_date`, `repeat_annually`, `purchase_product_id`, `purchase_product_cat_id`, `purchase_product_brand`, `purchase_amount`, `purchase_amount_type`, `amount_discount_type`, `purchase_qty`, `purchase_qty_type`, `purchase_combination_counter`, `purchase_combination`, `activity_type`, `customer_limit`, `usage_limit`, `usage_limit_no`, `combination`, `availability`, `product_discount`, `discount_product_id`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '3y0DsYbo', 'Sample Coupon A', 'Test', 'Test', 'auto', 'all', NULL, NULL, NULL, 0.00, NULL, 20, NULL, 'ACTIVE', '2024-02-05', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 2000.00, 'min', 1, NULL, NULL, 1, 'amount|', NULL, 100000, NULL, NULL, 1, 0, NULL, NULL, 1, '2024-02-05 08:12:37', '2024-02-05 08:12:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_cart`
--

CREATE TABLE `coupon_cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) NOT NULL,
  `total_usage` int(11) NOT NULL DEFAULT '0',
  `discount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_cart_temp_discount`
--

CREATE TABLE `coupon_cart_temp_discount` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `coupon_discount` decimal(16,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_sales`
--

CREATE TABLE `coupon_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `coupon_id` int(11) NOT NULL,
  `coupon_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sales_header_id` int(11) NOT NULL,
  `order_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPAID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_coupons`
--

CREATE TABLE `customer_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `usage_status` int(11) NOT NULL DEFAULT '0',
  `coupon_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_favorites`
--

CREATE TABLE `customer_favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_libraries`
--

CREATE TABLE `customer_libraries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliverable_cities`
--

CREATE TABLE `deliverable_cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` decimal(16,2) NOT NULL DEFAULT '0.00',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PRIVATE',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecommerce_delivery_status`
--

CREATE TABLE `ecommerce_delivery_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Processing Stock',
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecommerce_sales_details`
--

CREATE TABLE `ecommerce_sales_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_header_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `product_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_category` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(16,4) NOT NULL,
  `tax_amount` decimal(16,4) NOT NULL,
  `promo_id` bigint(20) DEFAULT NULL,
  `promo_description` text COLLATE utf8mb4_unicode_ci,
  `discount_amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `gross_amount` decimal(16,4) NOT NULL,
  `net_amount` decimal(16,4) NOT NULL,
  `qty` decimal(16,2) NOT NULL,
  `uom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecommerce_sales_headers`
--

CREATE TABLE `ecommerce_sales_headers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `order_number` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `response_code` text COLLATE utf8mb4_unicode_ci,
  `order_source` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_contact_number` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_delivery_adress` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_delivery_zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_tracking_number` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_courier` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_type` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_fee_amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `delivery_fee_discount` decimal(16,2) DEFAULT NULL,
  `delivery_status` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Waiting for Payment',
  `gross_amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `tax_amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `net_amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `discount_amount` decimal(16,4) NOT NULL DEFAULT '0.0000',
  `payment_status` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'UNPAID',
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `other_instruction` text COLLATE utf8mb4_unicode_ci,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecommerce_sales_payments`
--

CREATE TABLE `ecommerce_sales_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sales_header_id` bigint(20) NOT NULL,
  `payment_type` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(16,4) NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` date NOT NULL DEFAULT '2024-01-30',
  `receipt_number` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(11) NOT NULL,
  `response_body` text COLLATE utf8mb4_unicode_ci,
  `response_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecommerce_shopping_cart`
--

CREATE TABLE `ecommerce_shopping_cart` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(16,4) NOT NULL,
  `discount_amount` decimal(16,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ecommerce_shopping_cart`
--

INSERT INTO `ecommerce_shopping_cart` (`id`, `user_id`, `product_id`, `qty`, `price`, `discount_amount`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 4, 220.0000, 0.00, '2024-02-05 08:12:51', '2024-02-06 06:44:11'),
(3, 0, 4, 20, 125.0000, 0.00, '2024-02-06 03:00:57', '2024-02-06 03:00:57');

-- --------------------------------------------------------

--
-- Table structure for table `ecredits`
--

CREATE TABLE `ecredits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `balance` decimal(16,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_recipients`
--

CREATE TABLE `email_recipients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_attributes`
--

CREATE TABLE `form_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_receiver_details`
--

CREATE TABLE `inventory_receiver_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `inventory` int(11) NOT NULL DEFAULT '0',
  `header_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_receiver_details`
--

INSERT INTO `inventory_receiver_details` (`id`, `product_id`, `inventory`, `header_id`, `created_at`, `updated_at`) VALUES
(1, 1, 11, 1, '2024-02-05 08:05:07', '2024-02-05 08:05:07'),
(2, 3, 50, 2, '2024-02-06 02:59:18', '2024-02-06 02:59:18'),
(3, 4, 30, 3, '2024-02-06 02:59:26', '2024-02-06 02:59:26'),
(4, 5, 50, 4, '2024-02-06 02:59:37', '2024-02-06 02:59:37'),
(5, 6, 20, 5, '2024-02-06 02:59:48', '2024-02-06 02:59:48'),
(6, 7, 50, 6, '2024-02-06 03:00:02', '2024-02-06 03:00:02'),
(7, 8, 15, 7, '2024-02-06 03:00:15', '2024-02-06 03:00:15'),
(8, 1, 5, 8, '2024-02-06 03:52:00', '2024-02-06 03:52:00'),
(9, 2, 10, 8, '2024-02-06 03:52:00', '2024-02-06 03:52:00'),
(10, 4, 5, 8, '2024-02-06 03:52:00', '2024-02-06 03:52:00'),
(11, 1, 5, 9, '2024-02-06 03:52:22', '2024-02-06 03:52:22'),
(12, 2, 10, 9, '2024-02-06 03:52:22', '2024-02-06 03:52:22'),
(13, 4, 5, 9, '2024-02-06 03:52:22', '2024-02-06 03:52:22'),
(14, 1, 5, 10, '2024-02-06 03:52:31', '2024-02-06 03:52:31'),
(15, 2, 10, 10, '2024-02-06 03:52:31', '2024-02-06 03:52:31'),
(16, 4, 5, 10, '2024-02-06 03:52:31', '2024-02-06 03:52:31'),
(17, 1, 1, 11, '2024-02-06 03:56:08', '2024-02-06 03:56:08');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_receiver_header`
--

CREATE TABLE `inventory_receiver_header` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `posted_at` datetime DEFAULT NULL,
  `posted_by` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SAVED',
  `cancelled_at` datetime DEFAULT NULL,
  `cancelled_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_receiver_header`
--

INSERT INTO `inventory_receiver_header` (`id`, `posted_at`, `posted_by`, `user_id`, `status`, `cancelled_at`, `cancelled_by`, `created_at`, `updated_at`) VALUES
(1, '2024-02-05 16:05:07', 1, 1, 'POSTED', NULL, NULL, '2024-02-05 08:05:07', '2024-02-05 08:05:07'),
(2, '2024-02-06 10:59:18', 1, 1, 'POSTED', NULL, NULL, '2024-02-06 02:59:18', '2024-02-06 02:59:18'),
(3, '2024-02-06 10:59:26', 1, 1, 'POSTED', NULL, NULL, '2024-02-06 02:59:26', '2024-02-06 02:59:26'),
(4, '2024-02-06 10:59:37', 1, 1, 'POSTED', NULL, NULL, '2024-02-06 02:59:37', '2024-02-06 02:59:37'),
(5, '2024-02-06 10:59:48', 1, 1, 'POSTED', NULL, NULL, '2024-02-06 02:59:48', '2024-02-06 02:59:48'),
(6, '2024-02-06 11:00:02', 1, 1, 'POSTED', NULL, NULL, '2024-02-06 03:00:02', '2024-02-06 03:00:02'),
(7, '2024-02-06 11:00:15', 1, 1, 'POSTED', NULL, NULL, '2024-02-06 03:00:15', '2024-02-06 03:00:15'),
(8, NULL, NULL, 1, 'SAVED', NULL, NULL, '2024-02-06 03:52:00', '2024-02-06 03:52:00'),
(9, '2024-02-06 11:52:43', 1, 1, 'POSTED', NULL, NULL, '2024-02-06 03:52:22', '2024-02-06 03:52:43'),
(10, NULL, NULL, 1, 'CANCELLED', '2024-02-06 11:52:33', 1, '2024-02-06 03:52:31', '2024-02-06 03:52:33'),
(11, '2024-02-06 11:56:11', 1, 1, 'POSTED', NULL, NULL, '2024-02-06 03:56:08', '2024-02-06 03:56:11');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '0',
  `pages_json` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `is_active`, `pages_json`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Menu 1', 1, '[{\"label\":\"Home\",\"type\":\"page\",\"page_id\":1,\"id\":1},{\"label\":\"About Us\",\"type\":\"page\",\"page_id\":2,\"id\":2},{\"label\":\"Blog\",\"type\":\"page\",\"page_id\":4,\"id\":3},{\"label\":\"Contact Us\",\"type\":\"page\",\"page_id\":3,\"id\":4}]', NULL, '2024-01-30 06:25:03', '2024-02-06 02:17:56', NULL),
(2, 'Test Menu', 0, '[{\"label\":\"Home\",\"type\":\"page\",\"page_id\":1},{\"label\":\"About Us\",\"type\":\"page\",\"page_id\":2},{\"label\":\"Contact Us\",\"type\":\"page\",\"page_id\":3},{\"label\":\"Blog\",\"type\":\"page\",\"page_id\":4}]', NULL, '2024-02-06 02:30:20', '2024-02-06 02:30:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menus_has_pages`
--

CREATE TABLE `menus_has_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `page_order` int(11) NOT NULL,
  `label` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` text COLLATE utf8mb4_unicode_ci,
  `target` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus_has_pages`
--

INSERT INTO `menus_has_pages` (`id`, `menu_id`, `parent_id`, `page_id`, `page_order`, `label`, `uri`, `target`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 0, 1, 1, 'Home', '', '', 'page', '2024-01-30 06:25:03', '2024-02-06 02:06:50', NULL),
(2, 1, 0, 2, 2, 'About Us', '', '', 'page', '2024-01-30 06:25:03', '2024-02-06 02:06:50', NULL),
(3, 1, 0, 4, 3, 'Blog', '', '', 'page', '2024-01-30 06:25:03', '2024-02-06 02:17:56', NULL),
(4, 1, 0, 3, 4, 'Contact Us', NULL, '', 'page', '2024-02-06 02:06:50', '2024-02-06 02:06:50', NULL),
(5, 2, 0, 1, 1, 'Home', NULL, '', 'page', '2024-02-06 02:30:20', '2024-02-06 02:30:20', NULL),
(6, 2, 0, 2, 2, 'About Us', NULL, '', 'page', '2024-02-06 02:30:20', '2024-02-06 02:30:20', NULL),
(7, 2, 0, 3, 3, 'Contact Us', NULL, '', 'page', '2024-02-06 02:30:20', '2024-02-06 02:30:20', NULL),
(8, 2, 0, 4, 4, 'Blog', NULL, '', 'page', '2024-02-06 02:30:20', '2024-02-06 02:30:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_01_070553_create_banners_table', 1),
(4, '2019_08_01_074749_create_albums_table', 1),
(5, '2019_08_01_080124_create_pages_table', 1),
(6, '2019_08_01_081226_create_menus_table', 1),
(7, '2019_08_01_081727_create_menus_has_pages_table', 1),
(8, '2019_08_01_083635_create_settings_table', 1),
(9, '2019_08_02_023228_create_permission_table', 1),
(10, '2019_08_02_023316_create_role_table', 1),
(11, '2019_08_02_023344_create_role_permission_table', 1),
(12, '2019_08_07_085124_create_options_table', 1),
(13, '2019_08_19_000000_create_failed_jobs_table', 1),
(14, '2019_09_06_001827_create_article_table', 1),
(15, '2019_09_06_014453_create_view_role_permission', 1),
(16, '2019_09_06_015345_create_view_access_permission_per_role', 1),
(17, '2019_09_06_061723_create_cms_activity_logs', 1),
(18, '2019_09_12_070707_create_article_category_table', 1),
(19, '2019_11_17_120625_create_social_media_accounts_table', 1),
(20, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(21, '2021_03_04_113705_add_contact_us_email_layout_in_settings_table', 1),
(22, '2021_03_04_113732_create_email_recipients_table', 1),
(23, '2021_12_06_074124_create_product_categories_table', 1),
(24, '2021_12_06_074143_create_products_table', 1),
(25, '2021_12_06_074159_create_product_photos_table', 1),
(26, '2021_12_06_074210_create_product_tags_table', 1),
(27, '2021_12_07_003002_create_inventory_receiver_headers_table', 1),
(28, '2021_12_07_003011_create_inventory_receiver_details_table', 1),
(29, '2021_12_07_053412_create_ecommerce_sales_details_table', 1),
(30, '2021_12_07_053422_create_ecommerce_sales_header_table', 1),
(31, '2021_12_07_053433_create_ecommerce_sales_payments_table', 1),
(32, '2021_12_07_053445_create_ecommerce_delivery_status', 1),
(33, '2021_12_07_095243_create_promos_table', 1),
(34, '2021_12_07_095252_create_promo_products_table', 1),
(35, '2021_12_09_100708_create_deliverablecities_table', 1),
(36, '2021_12_13_012012_create_favorite_table', 1),
(37, '2021_12_13_012027_create_customer_favorite_table', 1),
(38, '2021_12_13_012036_create_wishlist_table', 1),
(39, '2021_12_13_100927_create_cart_table', 1),
(40, '2021_12_18_072609_create_coupons_table', 1),
(41, '2021_12_18_072627_create_customer_coupons_table', 1),
(42, '2021_12_18_072642_create_coupon_cart_table', 1),
(43, '2021_12_18_072649_create_coupon_sales_table', 1),
(44, '2021_12_18_072702_create_coupon_cart_temp_discount', 1),
(45, '2022_04_17_122841_create_brands_table', 1),
(46, '2022_04_20_033756_create_paynamics_logs_table', 1),
(47, '2022_08_30_131019_create_form_attributes_table', 1),
(48, '2022_08_30_131315_create_product_additional_infos_table', 1),
(49, '2024_01_30_140621_create_advertisements_table', 1),
(50, '2024_01_30_140810_create_subscriptions_table', 1),
(51, '2024_01_30_140825_create_customer_libraries_table', 1),
(52, '2024_01_30_140839_create_ecredits_table', 1),
(53, '2024_01_30_141756_create_subscribers_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_type` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `type`, `name`, `value`, `field_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'animation', 'Fade In', 'fadeIn', 'entrance', NULL, NULL, NULL),
(2, 'animation', 'Fade Out', 'fadeOut', 'exit', NULL, NULL, NULL),
(3, 'animation', 'Fade In Down', 'fadeInDown', 'entrance', NULL, NULL, NULL),
(4, 'animation', 'Fade Out Down', 'fadeOutDown', 'exit', NULL, NULL, NULL),
(5, 'animation', 'Fade In Down Big', 'fadeInDownBig', 'entrance', NULL, NULL, NULL),
(6, 'animation', 'Fade Out Down Big', 'fadeOutDownBig', 'exit', NULL, NULL, NULL),
(7, 'animation', 'Fade In Left', 'fadeInLeft', 'entrance', NULL, NULL, NULL),
(8, 'animation', 'Fade Out Left', 'fadeOutLeft', 'exit', NULL, NULL, NULL),
(9, 'animation', 'Fade In Left Big', 'fadeInLeftBig', 'entrance', NULL, NULL, NULL),
(10, 'animation', 'Fade Out Left Big', 'fadeOutDownBig', 'exit', NULL, NULL, NULL),
(11, 'animation', 'Fade In Right', 'fadeInRight', 'entrance', NULL, NULL, NULL),
(12, 'animation', 'Fade Out Right', 'fadeOutRight', 'exit', NULL, NULL, NULL),
(13, 'animation', 'Fade In Right Big', 'fadeInRightBig', 'entrance', NULL, NULL, NULL),
(14, 'animation', 'Fade Out Right Big', 'fadeInRightBig', 'exit', NULL, NULL, NULL),
(15, 'animation', 'Fade In Up', 'fadeInUp', 'entrance', NULL, NULL, NULL),
(16, 'animation', 'Fade Out Up', 'fadeOutUp', 'exit', NULL, NULL, NULL),
(17, 'animation', 'Fade In Up Big', 'fadeInUpBig', 'entrance', NULL, NULL, NULL),
(18, 'animation', 'Fade Out Up Big', 'fadeInUpBig', 'exit', NULL, NULL, NULL),
(19, 'animation', 'Bounce In', 'bounceIn', 'entrance', NULL, NULL, NULL),
(20, 'animation', 'Bounce Out', 'bounceOut', 'exit', NULL, NULL, NULL),
(21, 'animation', 'Bounce In Down', 'bounceInDown', 'entrance', NULL, NULL, NULL),
(22, 'animation', 'Bounce Out Down', 'bounceOutDown', 'exit', NULL, NULL, NULL),
(23, 'animation', 'Bounce In Left', 'bounceInLeft', 'entrance', NULL, NULL, NULL),
(24, 'animation', 'Bounce Out Left', 'bounceOutLeft', 'exit', NULL, NULL, NULL),
(25, 'animation', 'Bounce In Right', 'bounceInRight', 'entrance', NULL, NULL, NULL),
(26, 'animation', 'Bounce Out Right', 'bounceOutRight', 'exit', NULL, NULL, NULL),
(27, 'animation', 'Bounce In Up', 'bounceInUp', 'entrance', NULL, NULL, NULL),
(28, 'animation', 'Bounce Out Up', 'bounceOutUp', 'exit', NULL, NULL, NULL),
(29, 'animation', 'Route In', 'rotateIn', 'entrance', NULL, NULL, NULL),
(30, 'animation', 'Route Out', 'rotateOut', 'exit', NULL, NULL, NULL),
(31, 'animation', 'Route In Down Left', 'rotateInDownLeft', 'entrance', NULL, NULL, NULL),
(32, 'animation', 'Route Out Down Left', 'rotateOutDownLeft', 'exit', NULL, NULL, NULL),
(33, 'animation', 'Route In Down Right', 'rotateInDownRight', 'entrance', NULL, NULL, NULL),
(34, 'animation', 'Route Out Down Right', 'rotateOutDownRight', 'exit', NULL, NULL, NULL),
(35, 'animation', 'Route In Up Left', 'rotateInUpLeft', 'entrance', NULL, NULL, NULL),
(36, 'animation', 'Route Out Up Left', 'rotateOutUpLeft', 'exit', NULL, NULL, NULL),
(37, 'animation', 'Route In Up Right', 'rotateInUpRight', 'entrance', NULL, NULL, NULL),
(38, 'animation', 'Route Out Up Right', 'rotateOutUpRight', 'exit', NULL, NULL, NULL),
(39, 'animation', 'Slide In Up', 'slideInUp', 'entrance', NULL, NULL, NULL),
(40, 'animation', 'Slide Out Up', 'slideOutUp', 'exit', NULL, NULL, NULL),
(41, 'animation', 'Slide In Down', 'slideInDown', 'entrance', NULL, NULL, NULL),
(42, 'animation', 'Slide Out Down', 'slideOutDown', 'exit', NULL, NULL, NULL),
(43, 'animation', 'Slide In Left', 'slideInLeft', 'entrance', NULL, NULL, NULL),
(44, 'animation', 'Slide Out Left', 'slideOutLeft', 'exit', NULL, NULL, NULL),
(45, 'animation', 'Slide In Right', 'slideInRight', 'entrance', NULL, NULL, NULL),
(46, 'animation', 'Slide Out Right', 'slideOutRight', 'exit', NULL, NULL, NULL),
(47, 'animation', 'Zoom In', 'zoomIn', 'entrance', NULL, NULL, NULL),
(48, 'animation', 'Zoom Out', 'zoomOut', 'exit', NULL, NULL, NULL),
(49, 'animation', 'Zoom In Down', 'zoomInDown', 'entrance', NULL, NULL, NULL),
(50, 'animation', 'Zoom Out Down', 'zoomOutDown', 'exit', NULL, NULL, NULL),
(51, 'animation', 'Zoom In Left', 'zoomInLeft', 'entrance', NULL, NULL, NULL),
(52, 'animation', 'Zoom Out Left', 'zoomOutLeft', 'exit', NULL, NULL, NULL),
(53, 'animation', 'Zoom In Right', 'zoomInRight', 'entrance', NULL, NULL, NULL),
(54, 'animation', 'Zoom Out Right', 'zoomOutRight', 'exit', NULL, NULL, NULL),
(55, 'animation', 'Zoom In Up', 'zoomInUp', 'entrance', NULL, NULL, NULL),
(56, 'animation', 'Zoom Out Up', 'zoomOutUp', 'exit', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_page_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contents` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `page_type` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'custom',
  `image_url` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keyword` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `parent_page_id`, `album_id`, `slug`, `name`, `label`, `contents`, `status`, `page_type`, `image_url`, `meta_title`, `meta_keyword`, `meta_description`, `user_id`, `template`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 1, 'home', 'Home', 'Home', '<div class=\"container topmargin-lg bottommargin-lg\"><div class=\"row\"><div class=\"col-md-5\" id=\"iazs\"><div class=\"heading-block border-bottom-0\"><h1>Welcome to our website!</h1></div><p class=\"lead\">Integer luctus, odio sit amet ultricies feugiat, urna massa suscipit lectus, vel eleifend justo libero et ex.</p><blockquote id=\"iqfa\">\r\n                            Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc semper tortor in nulla fermentum imperdiet.\r\n                        </blockquote><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/about-us\" id=\"itiaj\" class=\"btn bg-color text-white\">Read more about us</a><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/books\" id=\"ir0xp\" class=\"btn bg-color text-white\">See all our books</a></div><div class=\"col-md-7 align-self-end\"><div class=\"position-relative overflow-hidden\"><img src=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/misc/devices.png\" data-animate=\"fadeInUp\" data-delay=\"100\" alt=\"Chrome\"/></div></div></div></div><div class=\"section dark my-0\" id=\"img4v\"><div class=\"container\"><div class=\"heading-block center border-bottom-0\"><h3>Featured Books</h3></div><div id=\"oc-portfolio\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"4\" class=\"owl-carousel portfolio-carousel carousel-widget\">\r\n                        {Featured Products}\r\n                    </div><div class=\"text-center m-auto w-75\"><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/books\" id=\"i3hto\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a></div></div></div><div class=\"section my-0\"><div class=\"container\"><div class=\"heading-block center border-bottom-0\"><h3>Best Sellers</h3></div><div id=\"oc-portfolio-2\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"5\" class=\"owl-carousel portfolio-carousel carousel-widget\">\r\n                        {Best Sellers}\r\n                    </div><div class=\"text-center m-auto w-75\"><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/books\" id=\"i3i2i\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a></div></div></div><div class=\"section my-0\" id=\"i2d05\"><div class=\"container\" id=\"ihifs\"><div class=\"heading-block center border-bottom-0\"><h3>New Releases</h3></div><div id=\"oc-portfolio-3\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-xl=\"5\" class=\"owl-carousel portfolio-carousel carousel-widget\">\r\n                        {New Releases}\r\n                    </div><div class=\"text-center m-auto w-75\"><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/books\" id=\"iea9c\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">View All</a></div></div></div><div class=\"section my-0\"><div class=\"container\" id=\"id5th\"><div class=\"heading-block center\"><h3>Latest News</h3></div><div id=\"oc-posts\" data-pagi=\"false\" data-items-xs=\"1\" data-items-sm=\"2\" data-items-md=\"3\" data-items-lg=\"4\" class=\"owl-carousel posts-carousel carousel-widget posts-md\">\r\n                        {Featured Articles}\r\n                    </div><div class=\"text-center m-auto w-75\"><a href=\"https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/news\" id=\"izfmr\" class=\"button button-border button-rounded ms-0 topmargin-sm button-small\">Read More</a></div></div></div>', 'PUBLISHED', 'default', '', 'Home', 'home', 'Home page', '1', 'home', '2024-01-30 06:25:03', '2024-02-06 01:20:06', NULL),
(2, 0, 0, 'about-us', 'About Us', 'About Us', '\n            <h2>Who We Are</h2>\n\n            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"</p>\n\n            <p class=\"nobottommargin\">\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>', 'PUBLISHED', 'standard', '', 'About Us', 'About Us', 'About Us page', '1', '', '2024-01-30 06:25:03', '2024-01-30 06:25:03', NULL),
(3, 0, 0, 'contact-us', 'Contact Us', 'Contact Us', '\n            <h3>Contact Details</h3>\n                        \n            <div class=\"row\">\n                <div class=\"col-md-6\">\n                    <fieldset>\n                        <strong>Mailing Address:</strong><br>\n                        Unit 907-909 Antel Global Corporate Center, Julia Vargas<br>\n                        Avenue, Ortigas Center, Pasig City, Philippines<br>\n                    </fieldset>\n                    \n                    <fieldset>\n                        <strong>E-mail:</strong><br>\n                        Sales: sales@webfocus.ph<br>\n                        Marketing: marketing@webfocus.ph<br>\n                        Billing: billing@webfocus.ph<br>\n                        Customer Care: customercare@webfocus.ph<br>\n                        Tech Support: support@webfocus.ph<br>\n                    </fieldset>\n                </div>\n                <div class=\"col-md-3\">\n                    <fieldset>\n                        <strong>Telephone:</strong><br>\n                        +63 (2) 8706-6144<br>\n                        +63 (2) 8706-5796<br>\n                        +63 (2) 8511-0528<br>\n                        +63 (2) 8709-8061<br>\n                        +63 (2) 8806-5201<br>\n                    </fieldset>\n                </div>\n                \n                <div class=\"col-md-3\">\n                    <fieldset>\n                        <strong>Mobile:</strong><br>\n                        +63 908 869 4069 (Smart)<br>\n                        +63 917 569 7380 (Globe)<br>\n                        +63 922 330 8373 (Sun)<br>\n                    </fieldset>\n                </div>\n            </div>\n\n            <iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.2644008336374!2d121.06034437481797!3d14.5840041774833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c869d9acf3bd%3A0x3d08a34bc750b469!2sWebFocus%20Solutions%2C%20Inc.!5e0!3m2!1sen!2sph!4v1683084531924!5m2!1sen!2sph\" width=\"100%\" height=\"55\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>\n\n            <div class=\"row topmargin d-none\">\n                <div class=\"col-lg-6\">\n                    <address>\n                        <abbr title=\"Address\">Address:</abbr><br>\n                        444a EDSA, Guadalupe Viejo, Makati City, Philippines 1211\n                    </address>\n                </div>\n                <div class=\"col-lg-6\">\n                    <p><abbr title=\"Email Address\">Email:</abbr><br>info@vanguard.edu.ph</p>\n                </div>\n                <div class=\"col-lg-6\">\n                    <p class=\"nomargin\"><abbr title=\"Phone Number\">Phone:</abbr><br>(632) 8-1234-4567</p>\n                </div>\n                <div class=\"col-lg-6\">\n                    <p class=\"nomargin\"><abbr title=\"Phone Number\">Fax:</abbr><br>(632) 8-1234-4567</p>\n                </div>\n            </div>', 'PUBLISHED', 'standard', '', 'Contact Us', 'Contact Us', 'Contact Us page', '1', 'contact-us', '2024-01-30 06:25:03', '2024-01-30 06:25:03', NULL),
(4, 0, 0, 'news', 'News and Updates', 'Blog', '', 'PUBLISHED', 'customize', '', 'News', 'news', 'News page', '1', 'news', '2024-01-30 06:25:03', '2024-02-06 02:17:56', NULL),
(5, 0, 0, 'footer', 'Footer', 'footer', '\n            <div class=\"container clearfix\">\n                <div class=\"footer-widgets-wrap pb-3 border-bottom clearfix\">\n                    <div class=\"row\">\n                        <div class=\"col-lg-6 col-md-6 col-12\">\n                            <div class=\"d-flex clearfix\">\n                                <div class=\"pe-4 ps-1\">\n                                    <i class=\"h3 icon-clock1\"></i>\n                                </div>\n                                <div class=\"flex-grow-1\">\n                                    <address>\n                                        <abbr title=\"address\"><strong>Our Office is open:</strong><br></abbr>\n                                        From Mondays to Fridays (Except Holidays)<br>\n                                        08:00AM to 05:00PM<br>\n                                    </address>\n                                </div>\n                            </div>\n                            <div class=\"d-flex clearfix\">\n                                <div class=\"pe-4 ps-1\">\n                                    <i class=\"icon-call h3\"></i>\n                                </div>\n                                <div class=\"flex-grow-1\">\n                                    <div class=\"bottommargin-sm\">\n                                        <abbr title=\"Phone Number\"><strong>Phone:</strong></abbr> +63 (02) 518-7610<br>\n                                    </div>\n                                </div>\n                            </div>\n                            <div class=\"d-flex align-items-center clearfix\">\n                                <div class=\"pe-4 ps-1\">\n                                    <i class=\"icon-envelope21 h3 mb-0\"></i>\n                                </div>\n                                <div class=\"flex-grow-1\">\n                                    <abbr title=\"Email Address\"><strong>Email:</strong></abbr> ebookstore@phr.com.ph\n                                </div>\n                            </div>\n\n                            {Social Media Icons}\n                        </div>\n                        \n                        <div class=\"col-lg-2 col-md-6 col-12\">\n                            <div class=\"widget clearfix\">\n\n                                <h4 class=\"ls0 mb-3 nott\">Customer Care</h4>\n\n                                <ul class=\"list-unstyled iconlist ms-0\">\n                                    <li><a href=\"#\">Terms of Use</a></li>\n                                    <li><a href=\"#\">FAQs</a></li>\n                                    <li><a href=\"#\">Privacy Policy</a></li>\n                                </ul>\n\n                            </div>\n                        </div>\n                        <div class=\"col-lg-4 col-md-12\">\n                            <div class=\"widget clearfix\">\n\n                                <h4 class=\"ls0 mb-3 nott\">Subscribe Now</h4>\n                                <div class=\"widget subscribe-widget mt-2 clearfix\">\n                                    <p class=\"mb-4\"><strong>Subscribe</strong> to Our Newsletter to get Important News, Amazing Offers &amp; Inside Scoops:</p>\n                                    <div class=\"widget-subscribe-form-result\"></div>\n                                    <form id=\"widget-subscribe-form\" action=\"include/subscribe.php\" method=\"post\" class=\"mt-1 mb-0 d-flex\">\n                                        <input type=\"email\" id=\"widget-subscribe-form-email\" name=\"widget-subscribe-form-email\" class=\"form-control sm-form-control required email\" placeholder=\"Enter your Email Address\">\n\n                                        <a href=\"#\" class=\"button nott fw-normal ms-1 my-0\" data-bs-toggle=\"modal\" data-bs-target=\".bs-example-modal-centered\">Subscribe Now</a>\n                                    </form>\n                                </div>\n                            </div>\n                        </div>\n                        \n                        <div class=\"modal fade bs-example-modal-centered\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"centerModalLabel\" aria-hidden=\"true\">\n                            <div class=\"modal-dialog modal-dialog-centered\">\n                                <div class=\"card rounded-1 dark\" style=\"background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.3)), url(https://cms4.webfocusprod.wsiph2.com/cms4-ecom-precious/public/theme/images/misc/subscribe.jpeg) no-repeat center center / cover; padding: 60px 50px; border: 12px solid #FFF\">\n                                    <div class=\"card-body\">\n                                        <div class=\"d-flex justify-content-between\">\n                                            <h2 class=\"card-title text-white font-body\">Subscribe to our Newsletter!</h2>\n                                        </div>\n                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cum nisi beatae temporibus nobis optio eos?</p>\n\n                                        <div class=\"subscribe-widget\" data-loader=\"button\">\n\n                                            <div class=\"widget-subscribe-form-result\"></div>\n\n                                            <form action=\"include/subscribe.php\" role=\"form\" method=\"post\" class=\"mb-0\">\n                                                <label for=\"widget-subscribe-form-email\">Name <span>*</span></label>\n                                                <input type=\"email\" name=\"widget-subscribe-form-email\" id=\"widget-subscribe-form-email\" class=\"form-control required not-dark\" placeholder=\"your name\">\n                                                <label for=\"widget-subscribe-form-email\">Email Address <span>*</span></label>\n                                                <input type=\"email\" name=\"widget-subscribe-form-email\" id=\"widget-subscribe-form-email\" class=\"form-control required not-dark\" placeholder=\"name@email.com\">\n                                                <button class=\"btn rounded btn-danger py-2 mt-3 w-100 text-uppercase ls1 fw-semibold\" type=\"submit\">Subscribe</button>\n                                            </form>\n\n                                        </div>\n                                    </div>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n            </div>\n\n            <div id=\"copyrights\" class=\"bg-transparent\">\n                <div class=\"container clearfix\">\n                    <div class=\"row justify-content-between align-items-center\">\n                        <div class=\"col-md-6\">\n                            Copyright &copy; 2023 All Rights Reserved, Precious Pages Corp.\n                        </div>\n\n                        <div class=\"col-md-6 d-md-flex flex-md-column align-items-md-end mt-4 mt-md-0\">\n                            <div class=\"copyrights-menu copyright-links clearfix\">\n                                <a href=\"#\">Home</a>/\n                                <a href=\"#\">About</a>/\n                                <a href=\"#\">Features</a>/\n                                <a href=\"#\">Portfolio</a>/\n                                <a href=\"#\">FAQs</a>/\n                                <a href=\"#\">Contact</a>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n            </div>', 'PUBLISHED', 'default', '', '', '', '', '1', '', '2024-01-30 06:25:03', '2024-01-30 06:25:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paynamics_logs`
--

CREATE TABLE `paynamics_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `result_return` text COLLATE utf8mb4_unicode_ci,
  `request_id` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_id` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_code` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_message` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `response_advise` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ptype` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rebill_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_id` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_info` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `processor_response_id` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `processor_response_authcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `routes` text COLLATE utf8mb4_unicode_ci,
  `methods` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) NOT NULL,
  `is_view_page` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `name`, `module`, `description`, `routes`, `methods`, `user_id`, `is_view_page`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'View Page', 'page', 'User can view page list and detail', '[\"pages.index\",\"pages.show\",\"pages.index.advance-search\"]', '[\"index\",\"show\",\"advance_index\"]', 1, 1, NULL, NULL, NULL),
(2, 'Create Page', 'page', 'User can create pages', '[\"pages.create\",\"pages.store\"]', '[\"create\",\"store\"]', 1, 0, NULL, NULL, NULL),
(3, 'Edit Page', 'page', 'User can edit pages', '[\"pages.edit\",\"pages.update\"]', '[\"edit\",\"update\"]', 1, 0, NULL, NULL, NULL),
(4, 'Delete/Restore page', 'page', 'User can delete and restore pages', '[\"pages.destroy\",\"pages.delete\",\"pages.restore\"]', '[\"destroy\",\"delete\",\"restore\"]', 1, 0, NULL, NULL, NULL),
(5, 'Change Status of Page', 'page', 'User can change status of pages', '[\"pages.change.status\"]', '[\"change_status\"]', 1, 0, NULL, NULL, NULL),
(6, 'View Album', 'banner', 'User can view album list and detail', '[\"albums.index\",\"albums.show\"]', '[\"index\",\"show\"]', 1, 1, NULL, NULL, NULL),
(7, 'Create Album', 'banner', 'User can create albums', '[\"albums.create\",\"albums.store\"]', '[\"create\",\"store\"]', 1, 0, NULL, NULL, NULL),
(8, 'Edit Album', 'banner', 'User can edit albums', '[\"albums.edit\",\"albums.update\",\"albums.quick_update\"]', '[\"edit\",\"update\",\"quick_update\"]', 1, 0, NULL, NULL, NULL),
(9, 'Delete/Restore album', 'banner', 'User can delete and restore albums', '[\"albums.destroy\",\"albums.destroy_many\",\"albums.restore\"]', '[\"destroy\",\"destroy_many\",\"restore\"]', 1, 0, NULL, NULL, NULL),
(10, 'Manage File manager', 'file_manager', 'User can manage file manager', '[\"file-manager.show\",\"file-manager.upload\",\"file-manager.index\"]', '[\"show\",\"upload\",\"index\"]', 1, 0, NULL, NULL, NULL),
(11, 'View menu', 'menu', 'User can view menu list and detail', '[\"menus.index\",\"menus.show\"]', '[\"index\",\"show\"]', 1, 1, NULL, NULL, NULL),
(12, 'Create Menu', 'menu', 'User can create menus', '[\"menus.create\",\"menus.store\"]', '[\"create\",\"store\"]', 1, 0, NULL, NULL, NULL),
(13, 'Edit Menu', 'menu', 'User can edit menus', '[\"menus.edit\",\"menus.update\"]', '[\"edit\",\"update\"]', 1, 0, NULL, NULL, NULL),
(14, 'Delete/Restore menu', 'menu', 'User can delete and restore menus', '[\"menus.destroy\",\"menus.destroy_many\",\"menus.restore\"]', '[\"destroy\",\"destroy_many\",\"restore\"]', 1, 0, NULL, NULL, NULL),
(15, 'View news', 'news', 'User can view news list and detail', '[\"news.index\",\"news.show\",\"news.index.advance-search\"]', '[\"index\",\"show\",\"advance_index\"]', 1, 1, NULL, NULL, NULL),
(16, 'Create News', 'news', 'User can create news', '[\"news.create\",\"news.store\"]', '[\"create\",\"store\"]', 1, 0, NULL, NULL, NULL),
(17, 'Edit news', 'news', 'User can edit news', '[\"news.edit\",\"news.update\"]', '[\"edit\",\"update\"]', 1, 0, NULL, NULL, NULL),
(18, 'Delete/Restore News', 'news', 'User can delete and restore news', '[\"news.destroy\",\"news.delete\",\"news.restore\"]', '[\"destroy\",\"delete\",\"restore\"]', 1, 0, NULL, NULL, NULL),
(19, 'Change Status of News', 'news', 'User can change status of news', '[\"news.change.status\"]', '[\"change_status\"]', 1, 0, NULL, NULL, NULL),
(20, 'View News Category', 'news_category', 'User can view news category list and details', '[\"news-categories.index\",\"news-categories.show\"]', '[\"index\",\"show\"]', 1, 1, NULL, NULL, NULL),
(21, 'Create news category', 'news_category', 'User can create news categories', '[\"news-categories.create\",\"news-categories.store\"]', '[\"create\",\"store\"]', 1, 0, NULL, NULL, NULL),
(22, 'Edit news category', 'news_category', 'User can edit news categories', '[\"news-categories.edit\",\"news-categories.update\"]', '[\"edit\",\"update\"]', 1, 0, NULL, NULL, NULL),
(23, 'Delete/Restore news category', 'news_category', 'User can delete and restore news categories', '[\"news-categories.destroy\",\"news-categories.delete\",\"news-categories.restore\"]', '[\"destroy\",\"delete\",\"restore\"]', 1, 0, NULL, NULL, NULL),
(24, 'Edit website settings', 'website_settings', 'User can edit website settings', '[\"website-settings.edit\",\"website-settings.update\",\"website-settings.update-contacts\",\"website-settings.update-media-accounts\",\"website-settings.update-data-privacy\",\"website-settings.remove-logo\",\"website-settings.remove-icon\",\"website-settings.remove-media\"]', '[\"edit\",\"update\",\"update_contacts\",\"update_media_accounts\",\"update_data_privacy\",\"remove_logo\",\"remove_icon\",\"remove_media\"]', 1, 1, NULL, NULL, NULL),
(25, 'View audit logs', 'audit_logs', 'User can view audit logs', '[\"audit-logs.index\"]', '[\"index\"]', 1, 1, NULL, NULL, NULL),
(26, 'View users', 'user', 'User can view user list and detail', '[\"users.index\",\"users.show\",\"user.search\",\"user.activity.search\"]', '[\"index\",\"show\",\"search\",\"filter\"]', 1, 1, NULL, NULL, NULL),
(27, 'Create user', 'user', 'User can create users', '[\"users.create\",\"users.store\"]', '[\"create\",\"store\"]', 1, 0, NULL, NULL, NULL),
(28, 'Edit user', 'user', 'User can edit users', '[\"users.edit\",\"users.update\"]', '[\"edit\",\"update\"]', 1, 0, NULL, NULL, NULL),
(29, 'Change status of user', 'user', 'User can change status of users', '[\"users.deactivate\",\"users.activate\"]', '[\"deactivate\",\"activate\"]', 1, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `book_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('physical','ebook') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'physical',
  `sku` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(16,4) DEFAULT NULL,
  `reorder_point` decimal(16,2) NOT NULL DEFAULT '0.00',
  `size` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texture` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PC',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `publication_date` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `meta_title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keyword` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `book_type`, `type`, `sku`, `name`, `subtitle`, `slug`, `short_description`, `description`, `price`, `reorder_point`, `size`, `weight`, `texture`, `status`, `uom`, `is_featured`, `publication_date`, `created_by`, `meta_title`, `meta_keyword`, `meta_description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Light Novel', 'physical', 'B1', 'Sample Book A', NULL, 'sample-book-a', NULL, '<p>Test Item</p>', 220.0000, 10.00, '1', '2000', 'texture', 'PUBLISHED', 'measure', 0, NULL, 1, NULL, NULL, NULL, '2024-02-05 07:55:05', '2024-02-06 02:48:14', NULL),
(2, 1, 'Light Novel', 'physical', 'B2', 'Sample Book B', NULL, 'sample-book-b', NULL, '<p>Test</p>', 330.0000, 8.00, '1', '2000', 'texture', 'PUBLISHED', 'measure', 0, NULL, 1, NULL, NULL, NULL, '2024-02-05 08:10:36', '2024-02-06 02:48:23', NULL),
(3, 1, 'Short Novel', 'physical', 'S1', 'My Father Is A Hero', NULL, 'my-father-is-a-hero', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent varius suscipit felis, nec viverra erat aliquet quis. Nam non dolor et enim maximus viverra lacinia in ex. Maecenas maximus vehicula lectus et gravida. Ut et mattis sapien. Vivamus eget ultrices neque, et viverra justo. Donec vel maximus lacus. Curabitur laoreet mi quis nisl convallis, et varius felis condimentum. Vivamus ac tortor non nibh finibus lobortis. Integer euismod sem nibh, non scelerisque ante facilisis quis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi massa purus, aliquam in libero et, ultricies pharetra sapien. Sed sed purus venenatis, dapibus massa sit amet, imperdiet dolor. Fusce blandit arcu non convallis maximus. Aliquam malesuada, nulla sed scelerisque pulvinar, est massa posuere urna, vulputate malesuada nibh augue vel sapien.</p>\r\n\r\n<p>Vivamus ornare venenatis felis eget facilisis. Cras faucibus metus et arcu tempus, id pharetra lacus vehicula. Nulla elit nisi, iaculis in libero a, posuere auctor odio. Vivamus laoreet placerat porta. Sed interdum aliquet lorem eu feugiat. Quisque volutpat convallis ligula. Nulla facilisi. Sed ut nulla porttitor, vestibulum nunc quis, tincidunt eros. Nam eget congue ante, vehicula posuere arcu. Phasellus gravida velit non accumsan varius. Donec efficitur sapien lacus.</p>\r\n\r\n<p>Maecenas pharetra neque eu dignissim commodo. Nullam vestibulum blandit ornare. Curabitur tincidunt laoreet rutrum. Donec blandit arcu et metus malesuada pharetra. Morbi viverra nulla eget enim malesuada consequat. Quisque dapibus nec libero iaculis tempus. Sed ullamcorper dui in odio lacinia vulputate. Nullam non lacinia libero. Donec consequat ante sit amet odio maximus consectetur.</p>\r\n\r\n<p>Aenean consequat blandit volutpat. Vivamus et aliquam nisl, a tincidunt felis. Curabitur laoreet, metus quis dictum mattis, metus lacus blandit nisl, volutpat egestas leo orci vel enim. Fusce urna nibh, pretium vestibulum convallis sit amet, pretium eu sem. Proin eu varius est, vel tristique magna. Integer rutrum, lectus id rutrum laoreet, diam lacus facilisis nibh, eu luctus nisl eros non enim. Aenean consequat non dolor in ultrices. Duis sed condimentum sapien. Suspendisse neque augue, gravida at leo id, vulputate sollicitudin metus. Aenean suscipit ullamcorper elit, at porta leo faucibus id. Vestibulum ac odio vulputate, laoreet tellus imperdiet, sollicitudin enim. Phasellus ornare pretium ligula. Ut porta mollis arcu ut porta. Sed mattis tempus tristique. Vestibulum sollicitudin facilisis porttitor.</p>\r\n\r\n<p>Sed tellus orci, volutpat nec diam at, tempor dignissim erat. Nulla in urna nunc. Curabitur et congue tortor, id porttitor diam. Sed quis lectus vitae lorem varius laoreet non nec arcu. Nullam vel odio in lectus dapibus gravida eget quis felis. Maecenas dictum quam eget libero congue varius. Phasellus euismod sagittis magna, eget facilisis purus dictum eget. Ut pharetra, dolor sed pharetra suscipit, dolor purus egestas sem, in auctor ligula dui eu turpis. Phasellus vehicula posuere rhoncus. Sed dapibus ligula ex, sit amet tincidunt nisl congue at. Donec vestibulum sed arcu at hendrerit. Quisque commodo massa et eros scelerisque maximus. Donec ac dolor quam. Aliquam ac erat eget felis iaculis iaculis a ut enim.</p>', 125.0000, 10.00, '1', '500', 'texture', 'PUBLISHED', 'cm', 1, NULL, 1, NULL, NULL, NULL, '2024-02-06 02:54:20', '2024-02-06 03:01:48', NULL),
(4, 7, 'Magazine', 'physical', 'S2', 'Mother\'s Day Brunch Special', NULL, 'mothers-day-brunch-special', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent varius suscipit felis, nec viverra erat aliquet quis. Nam non dolor et enim maximus viverra lacinia in ex. Maecenas maximus vehicula lectus et gravida. Ut et mattis sapien. Vivamus eget ultrices neque, et viverra justo. Donec vel maximus lacus. Curabitur laoreet mi quis nisl convallis, et varius felis condimentum. Vivamus ac tortor non nibh finibus lobortis. Integer euismod sem nibh, non scelerisque ante facilisis quis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi massa purus, aliquam in libero et, ultricies pharetra sapien. Sed sed purus venenatis, dapibus massa sit amet, imperdiet dolor. Fusce blandit arcu non convallis maximus. Aliquam malesuada, nulla sed scelerisque pulvinar, est massa posuere urna, vulputate malesuada nibh augue vel sapien.</p>\r\n\r\n<p>Vivamus ornare venenatis felis eget facilisis. Cras faucibus metus et arcu tempus, id pharetra lacus vehicula. Nulla elit nisi, iaculis in libero a, posuere auctor odio. Vivamus laoreet placerat porta. Sed interdum aliquet lorem eu feugiat. Quisque volutpat convallis ligula. Nulla facilisi. Sed ut nulla porttitor, vestibulum nunc quis, tincidunt eros. Nam eget congue ante, vehicula posuere arcu. Phasellus gravida velit non accumsan varius. Donec efficitur sapien lacus.</p>\r\n\r\n<p>Maecenas pharetra neque eu dignissim commodo. Nullam vestibulum blandit ornare. Curabitur tincidunt laoreet rutrum. Donec blandit arcu et metus malesuada pharetra. Morbi viverra nulla eget enim malesuada consequat. Quisque dapibus nec libero iaculis tempus. Sed ullamcorper dui in odio lacinia vulputate. Nullam non lacinia libero. Donec consequat ante sit amet odio maximus consectetur.</p>\r\n\r\n<p>Aenean consequat blandit volutpat. Vivamus et aliquam nisl, a tincidunt felis. Curabitur laoreet, metus quis dictum mattis, metus lacus blandit nisl, volutpat egestas leo orci vel enim. Fusce urna nibh, pretium vestibulum convallis sit amet, pretium eu sem. Proin eu varius est, vel tristique magna. Integer rutrum, lectus id rutrum laoreet, diam lacus facilisis nibh, eu luctus nisl eros non enim. Aenean consequat non dolor in ultrices. Duis sed condimentum sapien. Suspendisse neque augue, gravida at leo id, vulputate sollicitudin metus. Aenean suscipit ullamcorper elit, at porta leo faucibus id. Vestibulum ac odio vulputate, laoreet tellus imperdiet, sollicitudin enim. Phasellus ornare pretium ligula. Ut porta mollis arcu ut porta. Sed mattis tempus tristique. Vestibulum sollicitudin facilisis porttitor.</p>\r\n\r\n<p>Sed tellus orci, volutpat nec diam at, tempor dignissim erat. Nulla in urna nunc. Curabitur et congue tortor, id porttitor diam. Sed quis lectus vitae lorem varius laoreet non nec arcu. Nullam vel odio in lectus dapibus gravida eget quis felis. Maecenas dictum quam eget libero congue varius. Phasellus euismod sagittis magna, eget facilisis purus dictum eget. Ut pharetra, dolor sed pharetra suscipit, dolor purus egestas sem, in auctor ligula dui eu turpis. Phasellus vehicula posuere rhoncus. Sed dapibus ligula ex, sit amet tincidunt nisl congue at. Donec vestibulum sed arcu at hendrerit. Quisque commodo massa et eros scelerisque maximus. Donec ac dolor quam. Aliquam ac erat eget felis iaculis iaculis a ut enim.</p>', 125.0000, 10.00, '1', '500', 'texture', 'PUBLISHED', 'texture', 1, NULL, 1, NULL, NULL, NULL, '2024-02-06 02:55:31', '2024-02-06 02:55:31', NULL),
(5, 7, 'Japanese Cuisine', 'physical', 'S3', 'Yanagi', NULL, 'yanagi', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent varius suscipit felis, nec viverra erat aliquet quis. Nam non dolor et enim maximus viverra lacinia in ex. Maecenas maximus vehicula lectus et gravida. Ut et mattis sapien. Vivamus eget ultrices neque, et viverra justo. Donec vel maximus lacus. Curabitur laoreet mi quis nisl convallis, et varius felis condimentum. Vivamus ac tortor non nibh finibus lobortis. Integer euismod sem nibh, non scelerisque ante facilisis quis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi massa purus, aliquam in libero et, ultricies pharetra sapien. Sed sed purus venenatis, dapibus massa sit amet, imperdiet dolor. Fusce blandit arcu non convallis maximus. Aliquam malesuada, nulla sed scelerisque pulvinar, est massa posuere urna, vulputate malesuada nibh augue vel sapien.</p>\r\n\r\n<p>Vivamus ornare venenatis felis eget facilisis. Cras faucibus metus et arcu tempus, id pharetra lacus vehicula. Nulla elit nisi, iaculis in libero a, posuere auctor odio. Vivamus laoreet placerat porta. Sed interdum aliquet lorem eu feugiat. Quisque volutpat convallis ligula. Nulla facilisi. Sed ut nulla porttitor, vestibulum nunc quis, tincidunt eros. Nam eget congue ante, vehicula posuere arcu. Phasellus gravida velit non accumsan varius. Donec efficitur sapien lacus.</p>\r\n\r\n<p>Maecenas pharetra neque eu dignissim commodo. Nullam vestibulum blandit ornare. Curabitur tincidunt laoreet rutrum. Donec blandit arcu et metus malesuada pharetra. Morbi viverra nulla eget enim malesuada consequat. Quisque dapibus nec libero iaculis tempus. Sed ullamcorper dui in odio lacinia vulputate. Nullam non lacinia libero. Donec consequat ante sit amet odio maximus consectetur.</p>\r\n\r\n<p>Aenean consequat blandit volutpat. Vivamus et aliquam nisl, a tincidunt felis. Curabitur laoreet, metus quis dictum mattis, metus lacus blandit nisl, volutpat egestas leo orci vel enim. Fusce urna nibh, pretium vestibulum convallis sit amet, pretium eu sem. Proin eu varius est, vel tristique magna. Integer rutrum, lectus id rutrum laoreet, diam lacus facilisis nibh, eu luctus nisl eros non enim. Aenean consequat non dolor in ultrices. Duis sed condimentum sapien. Suspendisse neque augue, gravida at leo id, vulputate sollicitudin metus. Aenean suscipit ullamcorper elit, at porta leo faucibus id. Vestibulum ac odio vulputate, laoreet tellus imperdiet, sollicitudin enim. Phasellus ornare pretium ligula. Ut porta mollis arcu ut porta. Sed mattis tempus tristique. Vestibulum sollicitudin facilisis porttitor.</p>\r\n\r\n<p>Sed tellus orci, volutpat nec diam at, tempor dignissim erat. Nulla in urna nunc. Curabitur et congue tortor, id porttitor diam. Sed quis lectus vitae lorem varius laoreet non nec arcu. Nullam vel odio in lectus dapibus gravida eget quis felis. Maecenas dictum quam eget libero congue varius. Phasellus euismod sagittis magna, eget facilisis purus dictum eget. Ut pharetra, dolor sed pharetra suscipit, dolor purus egestas sem, in auctor ligula dui eu turpis. Phasellus vehicula posuere rhoncus. Sed dapibus ligula ex, sit amet tincidunt nisl congue at. Donec vestibulum sed arcu at hendrerit. Quisque commodo massa et eros scelerisque maximus. Donec ac dolor quam. Aliquam ac erat eget felis iaculis iaculis a ut enim.</p>', 125.0000, 10.00, '1', '500', 'texture', 'PUBLISHED', 'cm', 1, NULL, 1, NULL, NULL, NULL, '2024-02-06 02:56:24', '2024-02-06 02:56:24', NULL),
(6, 7, 'Canvas', 'physical', 'S4', 'Pizza All You Can', NULL, 'pizza-all-you-can', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent varius suscipit felis, nec viverra erat aliquet quis. Nam non dolor et enim maximus viverra lacinia in ex. Maecenas maximus vehicula lectus et gravida. Ut et mattis sapien. Vivamus eget ultrices neque, et viverra justo. Donec vel maximus lacus. Curabitur laoreet mi quis nisl convallis, et varius felis condimentum. Vivamus ac tortor non nibh finibus lobortis. Integer euismod sem nibh, non scelerisque ante facilisis quis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi massa purus, aliquam in libero et, ultricies pharetra sapien. Sed sed purus venenatis, dapibus massa sit amet, imperdiet dolor. Fusce blandit arcu non convallis maximus. Aliquam malesuada, nulla sed scelerisque pulvinar, est massa posuere urna, vulputate malesuada nibh augue vel sapien.</p>\r\n\r\n<p>Vivamus ornare venenatis felis eget facilisis. Cras faucibus metus et arcu tempus, id pharetra lacus vehicula. Nulla elit nisi, iaculis in libero a, posuere auctor odio. Vivamus laoreet placerat porta. Sed interdum aliquet lorem eu feugiat. Quisque volutpat convallis ligula. Nulla facilisi. Sed ut nulla porttitor, vestibulum nunc quis, tincidunt eros. Nam eget congue ante, vehicula posuere arcu. Phasellus gravida velit non accumsan varius. Donec efficitur sapien lacus.</p>\r\n\r\n<p>Maecenas pharetra neque eu dignissim commodo. Nullam vestibulum blandit ornare. Curabitur tincidunt laoreet rutrum. Donec blandit arcu et metus malesuada pharetra. Morbi viverra nulla eget enim malesuada consequat. Quisque dapibus nec libero iaculis tempus. Sed ullamcorper dui in odio lacinia vulputate. Nullam non lacinia libero. Donec consequat ante sit amet odio maximus consectetur.</p>\r\n\r\n<p>Aenean consequat blandit volutpat. Vivamus et aliquam nisl, a tincidunt felis. Curabitur laoreet, metus quis dictum mattis, metus lacus blandit nisl, volutpat egestas leo orci vel enim. Fusce urna nibh, pretium vestibulum convallis sit amet, pretium eu sem. Proin eu varius est, vel tristique magna. Integer rutrum, lectus id rutrum laoreet, diam lacus facilisis nibh, eu luctus nisl eros non enim. Aenean consequat non dolor in ultrices. Duis sed condimentum sapien. Suspendisse neque augue, gravida at leo id, vulputate sollicitudin metus. Aenean suscipit ullamcorper elit, at porta leo faucibus id. Vestibulum ac odio vulputate, laoreet tellus imperdiet, sollicitudin enim. Phasellus ornare pretium ligula. Ut porta mollis arcu ut porta. Sed mattis tempus tristique. Vestibulum sollicitudin facilisis porttitor.</p>\r\n\r\n<p>Sed tellus orci, volutpat nec diam at, tempor dignissim erat. Nulla in urna nunc. Curabitur et congue tortor, id porttitor diam. Sed quis lectus vitae lorem varius laoreet non nec arcu. Nullam vel odio in lectus dapibus gravida eget quis felis. Maecenas dictum quam eget libero congue varius. Phasellus euismod sagittis magna, eget facilisis purus dictum eget. Ut pharetra, dolor sed pharetra suscipit, dolor purus egestas sem, in auctor ligula dui eu turpis. Phasellus vehicula posuere rhoncus. Sed dapibus ligula ex, sit amet tincidunt nisl congue at. Donec vestibulum sed arcu at hendrerit. Quisque commodo massa et eros scelerisque maximus. Donec ac dolor quam. Aliquam ac erat eget felis iaculis iaculis a ut enim.</p>', 125.0000, 10.00, '1', '500', 'texture', 'PUBLISHED', 'cm', 1, NULL, 1, NULL, NULL, NULL, '2024-02-06 02:57:12', '2024-02-06 02:57:12', NULL),
(7, 4, 'Light Hearted', 'physical', 'S5', 'My Dad', NULL, 'my-dad', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent varius suscipit felis, nec viverra erat aliquet quis. Nam non dolor et enim maximus viverra lacinia in ex. Maecenas maximus vehicula lectus et gravida. Ut et mattis sapien. Vivamus eget ultrices neque, et viverra justo. Donec vel maximus lacus. Curabitur laoreet mi quis nisl convallis, et varius felis condimentum. Vivamus ac tortor non nibh finibus lobortis. Integer euismod sem nibh, non scelerisque ante facilisis quis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi massa purus, aliquam in libero et, ultricies pharetra sapien. Sed sed purus venenatis, dapibus massa sit amet, imperdiet dolor. Fusce blandit arcu non convallis maximus. Aliquam malesuada, nulla sed scelerisque pulvinar, est massa posuere urna, vulputate malesuada nibh augue vel sapien.</p>\r\n\r\n<p>Vivamus ornare venenatis felis eget facilisis. Cras faucibus metus et arcu tempus, id pharetra lacus vehicula. Nulla elit nisi, iaculis in libero a, posuere auctor odio. Vivamus laoreet placerat porta. Sed interdum aliquet lorem eu feugiat. Quisque volutpat convallis ligula. Nulla facilisi. Sed ut nulla porttitor, vestibulum nunc quis, tincidunt eros. Nam eget congue ante, vehicula posuere arcu. Phasellus gravida velit non accumsan varius. Donec efficitur sapien lacus.</p>\r\n\r\n<p>Maecenas pharetra neque eu dignissim commodo. Nullam vestibulum blandit ornare. Curabitur tincidunt laoreet rutrum. Donec blandit arcu et metus malesuada pharetra. Morbi viverra nulla eget enim malesuada consequat. Quisque dapibus nec libero iaculis tempus. Sed ullamcorper dui in odio lacinia vulputate. Nullam non lacinia libero. Donec consequat ante sit amet odio maximus consectetur.</p>\r\n\r\n<p>Aenean consequat blandit volutpat. Vivamus et aliquam nisl, a tincidunt felis. Curabitur laoreet, metus quis dictum mattis, metus lacus blandit nisl, volutpat egestas leo orci vel enim. Fusce urna nibh, pretium vestibulum convallis sit amet, pretium eu sem. Proin eu varius est, vel tristique magna. Integer rutrum, lectus id rutrum laoreet, diam lacus facilisis nibh, eu luctus nisl eros non enim. Aenean consequat non dolor in ultrices. Duis sed condimentum sapien. Suspendisse neque augue, gravida at leo id, vulputate sollicitudin metus. Aenean suscipit ullamcorper elit, at porta leo faucibus id. Vestibulum ac odio vulputate, laoreet tellus imperdiet, sollicitudin enim. Phasellus ornare pretium ligula. Ut porta mollis arcu ut porta. Sed mattis tempus tristique. Vestibulum sollicitudin facilisis porttitor.</p>\r\n\r\n<p>Sed tellus orci, volutpat nec diam at, tempor dignissim erat. Nulla in urna nunc. Curabitur et congue tortor, id porttitor diam. Sed quis lectus vitae lorem varius laoreet non nec arcu. Nullam vel odio in lectus dapibus gravida eget quis felis. Maecenas dictum quam eget libero congue varius. Phasellus euismod sagittis magna, eget facilisis purus dictum eget. Ut pharetra, dolor sed pharetra suscipit, dolor purus egestas sem, in auctor ligula dui eu turpis. Phasellus vehicula posuere rhoncus. Sed dapibus ligula ex, sit amet tincidunt nisl congue at. Donec vestibulum sed arcu at hendrerit. Quisque commodo massa et eros scelerisque maximus. Donec ac dolor quam. Aliquam ac erat eget felis iaculis iaculis a ut enim.</p>', 125.0000, 10.00, '1', '500', 'texture', 'PUBLISHED', 'cm', 1, NULL, 1, NULL, NULL, NULL, '2024-02-06 02:58:08', '2024-02-06 02:58:08', NULL),
(8, 7, 'Cake!', 'physical', 'S6', 'Good News! Cake!', NULL, 'good-news-cake', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent varius suscipit felis, nec viverra erat aliquet quis. Nam non dolor et enim maximus viverra lacinia in ex. Maecenas maximus vehicula lectus et gravida. Ut et mattis sapien. Vivamus eget ultrices neque, et viverra justo. Donec vel maximus lacus. Curabitur laoreet mi quis nisl convallis, et varius felis condimentum. Vivamus ac tortor non nibh finibus lobortis. Integer euismod sem nibh, non scelerisque ante facilisis quis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Morbi massa purus, aliquam in libero et, ultricies pharetra sapien. Sed sed purus venenatis, dapibus massa sit amet, imperdiet dolor. Fusce blandit arcu non convallis maximus. Aliquam malesuada, nulla sed scelerisque pulvinar, est massa posuere urna, vulputate malesuada nibh augue vel sapien.</p>\r\n\r\n<p>Vivamus ornare venenatis felis eget facilisis. Cras faucibus metus et arcu tempus, id pharetra lacus vehicula. Nulla elit nisi, iaculis in libero a, posuere auctor odio. Vivamus laoreet placerat porta. Sed interdum aliquet lorem eu feugiat. Quisque volutpat convallis ligula. Nulla facilisi. Sed ut nulla porttitor, vestibulum nunc quis, tincidunt eros. Nam eget congue ante, vehicula posuere arcu. Phasellus gravida velit non accumsan varius. Donec efficitur sapien lacus.</p>\r\n\r\n<p>Maecenas pharetra neque eu dignissim commodo. Nullam vestibulum blandit ornare. Curabitur tincidunt laoreet rutrum. Donec blandit arcu et metus malesuada pharetra. Morbi viverra nulla eget enim malesuada consequat. Quisque dapibus nec libero iaculis tempus. Sed ullamcorper dui in odio lacinia vulputate. Nullam non lacinia libero. Donec consequat ante sit amet odio maximus consectetur.</p>\r\n\r\n<p>Aenean consequat blandit volutpat. Vivamus et aliquam nisl, a tincidunt felis. Curabitur laoreet, metus quis dictum mattis, metus lacus blandit nisl, volutpat egestas leo orci vel enim. Fusce urna nibh, pretium vestibulum convallis sit amet, pretium eu sem. Proin eu varius est, vel tristique magna. Integer rutrum, lectus id rutrum laoreet, diam lacus facilisis nibh, eu luctus nisl eros non enim. Aenean consequat non dolor in ultrices. Duis sed condimentum sapien. Suspendisse neque augue, gravida at leo id, vulputate sollicitudin metus. Aenean suscipit ullamcorper elit, at porta leo faucibus id. Vestibulum ac odio vulputate, laoreet tellus imperdiet, sollicitudin enim. Phasellus ornare pretium ligula. Ut porta mollis arcu ut porta. Sed mattis tempus tristique. Vestibulum sollicitudin facilisis porttitor.</p>\r\n\r\n<p>Sed tellus orci, volutpat nec diam at, tempor dignissim erat. Nulla in urna nunc. Curabitur et congue tortor, id porttitor diam. Sed quis lectus vitae lorem varius laoreet non nec arcu. Nullam vel odio in lectus dapibus gravida eget quis felis. Maecenas dictum quam eget libero congue varius. Phasellus euismod sagittis magna, eget facilisis purus dictum eget. Ut pharetra, dolor sed pharetra suscipit, dolor purus egestas sem, in auctor ligula dui eu turpis. Phasellus vehicula posuere rhoncus. Sed dapibus ligula ex, sit amet tincidunt nisl congue at. Donec vestibulum sed arcu at hendrerit. Quisque commodo massa et eros scelerisque maximus. Donec ac dolor quam. Aliquam ac erat eget felis iaculis iaculis a ut enim.</p>', 125.0000, 10.00, '1', '500', 'texture', 'PUBLISHED', 'cm', 1, NULL, 1, NULL, NULL, NULL, '2024-02-06 02:59:01', '2024-02-06 02:59:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_additional_infos`
--

CREATE TABLE `product_additional_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `parent_id`, `name`, `slug`, `description`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 'Novel', 'novel', NULL, 'PUBLISHED', 1, '2024-02-05 07:51:38', '2024-02-05 07:51:38', NULL),
(2, 0, 'Comic', 'comic', NULL, 'PUBLISHED', 1, '2024-02-05 07:51:51', '2024-02-05 07:51:51', NULL),
(3, 0, 'Health', 'health', NULL, 'PUBLISHED', 1, '2024-02-05 07:52:08', '2024-02-05 07:52:08', NULL),
(4, 0, 'Educational', 'educational', NULL, 'PUBLISHED', 1, '2024-02-05 07:52:21', '2024-02-05 07:52:21', NULL),
(5, 3, '123', '123', NULL, 'PRIVATE', 1, '2024-02-05 07:52:30', '2024-02-05 07:52:41', '2024-02-05 07:52:41'),
(6, 0, 'Cooking', 'cooking', NULL, 'PUBLISHED', 1, '2024-02-06 02:49:27', '2024-02-06 02:51:42', '2024-02-06 02:51:42'),
(7, 0, 'Food and Cooking', 'food-and-cooking', NULL, 'PUBLISHED', 1, '2024-02-06 02:49:47', '2024-02-06 02:49:50', NULL),
(8, 0, 'Romance', 'romance', NULL, 'PUBLISHED', 1, '2024-02-06 02:52:06', '2024-02-06 02:52:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_photos`
--

CREATE TABLE `product_photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_primary` tinyint(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_photos`
--

INSERT INTO `product_photos` (`id`, `product_id`, `name`, `description`, `path`, `status`, `is_primary`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, '', '', '4/book image2.png', 'PUBLISHED', 1, 1, '2024-02-06 02:55:31', '2024-02-06 02:55:31', NULL),
(2, 5, '', '', '5/book image3.png', 'PUBLISHED', 1, 1, '2024-02-06 02:56:24', '2024-02-06 02:56:24', NULL),
(3, 6, '', '', '6/book image4.png', 'PUBLISHED', 1, 1, '2024-02-06 02:57:12', '2024-02-06 02:57:12', NULL),
(4, 7, '', '', '7/book image5.png', 'PUBLISHED', 1, 1, '2024-02-06 02:58:08', '2024-02-06 02:58:08', NULL),
(5, 8, '', '', '8/book image6.png', 'PUBLISHED', 1, 1, '2024-02-06 02:59:01', '2024-02-06 02:59:01', NULL),
(6, 3, '', '', '3/book image1.png', 'PUBLISHED', 1, 1, '2024-02-06 03:01:48', '2024-02-06 03:01:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE `product_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `tag` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_tags`
--

INSERT INTO `product_tags` (`id`, `product_id`, `tag`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 1, 'sample', 1, '2024-02-06 02:48:14', '2024-02-06 02:48:14', NULL),
(4, 2, 'sample', 1, '2024-02-06 02:48:24', '2024-02-06 02:48:24', NULL),
(11, 3, 'sample', 1, '2024-02-06 03:01:48', '2024-02-06 03:01:48', NULL),
(6, 4, 'sample', 1, '2024-02-06 02:55:31', '2024-02-06 02:55:31', NULL),
(7, 5, 'sample', 1, '2024-02-06 02:56:24', '2024-02-06 02:56:24', NULL),
(8, 6, 'sample', 1, '2024-02-06 02:57:12', '2024-02-06 02:57:12', NULL),
(9, 7, 'sample', 1, '2024-02-06 02:58:08', '2024-02-06 02:58:08', NULL),
(10, 8, 'sample', 1, '2024-02-06 02:59:01', '2024-02-06 02:59:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `promo_start` datetime NOT NULL,
  `promo_end` datetime NOT NULL,
  `discount` int(11) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_expire` int(11) NOT NULL DEFAULT '0',
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_products`
--

CREATE TABLE `promo_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `promo_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `description`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'Administrator of the system', 1, NULL, NULL, NULL),
(2, 'Member', 'Member of the system', 1, NULL, NULL, NULL),
(6, 'Customer', 'Customer of the system', 1, NULL, NULL, NULL),
(7, 'Guest Viewer Only', 'Guest user that can only view items', 1, '2024-02-06 02:44:17', '2024-02-06 02:44:17', NULL),
(8, 'News Caster', 'Users with this role may create and manage news articles', 1, '2024-02-06 02:44:35', '2024-02-06 02:44:35', NULL),
(9, 'Page Manager', 'Users with this role may create and manage pages', 1, '2024-02-06 02:44:51', '2024-02-06 02:44:51', NULL),
(10, 'User Manager', 'Users with this role may create and manage users including their roles', 1, '2024-02-06 02:45:14', '2024-02-06 02:45:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `isAllowed` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `role_id`, `permission_id`, `user_id`, `isAllowed`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(2, 6, 1, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(3, 7, 1, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(4, 8, 1, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(5, 9, 1, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(6, 10, 1, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(7, 2, 2, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(8, 6, 2, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(9, 7, 2, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(10, 8, 2, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(11, 9, 2, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(12, 10, 2, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(13, 2, 3, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(14, 6, 3, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(15, 7, 3, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(16, 8, 3, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(17, 9, 3, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(18, 10, 3, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(19, 2, 4, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(20, 6, 4, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(21, 7, 4, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(22, 8, 4, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(23, 9, 4, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(24, 10, 4, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(25, 2, 5, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(26, 6, 5, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(27, 7, 5, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(28, 8, 5, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(29, 9, 5, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(30, 10, 5, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(31, 2, 6, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(32, 6, 6, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(33, 7, 6, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:15'),
(34, 8, 6, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(35, 9, 6, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(36, 10, 6, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(37, 2, 7, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(38, 6, 7, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(39, 7, 7, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(40, 8, 7, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(41, 9, 7, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(42, 10, 7, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(43, 2, 8, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(44, 6, 8, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(45, 7, 8, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(46, 8, 8, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(47, 9, 8, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(48, 10, 8, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(49, 2, 9, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(50, 6, 9, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(51, 7, 9, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(52, 8, 9, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(53, 9, 9, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(54, 10, 9, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(55, 2, 10, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(56, 6, 10, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(57, 7, 10, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(58, 8, 10, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(59, 9, 10, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(60, 10, 10, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(61, 2, 11, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(62, 6, 11, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(63, 7, 11, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(64, 8, 11, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(65, 9, 11, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(66, 10, 11, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(67, 2, 12, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(68, 6, 12, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(69, 7, 12, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(70, 8, 12, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(71, 9, 12, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(72, 10, 12, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(73, 2, 13, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(74, 6, 13, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(75, 7, 13, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(76, 8, 13, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(77, 9, 13, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(78, 10, 13, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(79, 2, 14, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(80, 6, 14, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(81, 7, 14, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(82, 8, 14, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(83, 9, 14, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(84, 10, 14, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(85, 2, 15, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(86, 6, 15, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(87, 7, 15, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(88, 8, 15, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(89, 9, 15, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(90, 10, 15, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(91, 2, 16, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(92, 6, 16, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(93, 7, 16, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(94, 8, 16, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(95, 9, 16, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(96, 10, 16, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(97, 2, 17, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(98, 6, 17, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(99, 7, 17, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(100, 8, 17, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(101, 9, 17, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(102, 10, 17, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(103, 2, 18, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(104, 6, 18, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(105, 7, 18, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(106, 8, 18, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(107, 9, 18, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(108, 10, 18, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(109, 2, 19, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(110, 6, 19, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(111, 7, 19, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(112, 8, 19, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(113, 9, 19, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(114, 10, 19, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(115, 2, 20, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(116, 6, 20, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(117, 7, 20, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(118, 8, 20, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(119, 9, 20, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(120, 10, 20, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(121, 2, 21, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(122, 6, 21, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(123, 7, 21, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(124, 8, 21, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(125, 9, 21, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(126, 10, 21, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(127, 2, 22, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(128, 6, 22, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(129, 7, 22, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(130, 8, 22, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(131, 9, 22, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(132, 10, 22, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(133, 2, 23, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(134, 6, 23, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(135, 7, 23, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(136, 8, 23, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(137, 9, 23, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(138, 10, 23, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(139, 2, 24, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(140, 6, 24, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(141, 7, 24, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(142, 8, 24, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(143, 9, 24, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(144, 10, 24, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(145, 2, 25, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(146, 6, 25, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(147, 7, 25, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(148, 8, 25, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(149, 9, 25, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(150, 10, 25, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(151, 2, 26, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(152, 6, 26, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(153, 7, 26, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(154, 8, 26, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(155, 9, 26, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(156, 10, 26, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(157, 2, 27, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(158, 6, 27, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(159, 7, 27, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(160, 8, 27, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(161, 9, 27, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(162, 10, 27, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(163, 2, 28, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(164, 6, 28, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(165, 7, 28, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(166, 8, 28, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(167, 9, 28, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(168, 10, 28, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38'),
(169, 2, 29, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(170, 6, 29, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(171, 7, 29, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(172, 8, 29, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(173, 9, 29, 1, 0, '2024-02-06 03:34:11', '2024-02-06 03:34:11'),
(174, 10, 29, 1, 1, '2024-02-06 03:34:11', '2024-02-06 03:34:38');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `api_key` text COLLATE utf8mb4_unicode_ci,
  `website_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website_favicon` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_logo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_favicon` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_about` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_analytics` text COLLATE utf8mb4_unicode_ci,
  `google_map` text COLLATE utf8mb4_unicode_ci,
  `google_recaptcha_sitekey` text COLLATE utf8mb4_unicode_ci,
  `google_recaptcha_secret` text COLLATE utf8mb4_unicode_ci,
  `data_privacy_title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_privacy_popup_content` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_privacy_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_media_accounts` text COLLATE utf8mb4_unicode_ci,
  `copyright` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `min_order` int(11) NOT NULL DEFAULT '0',
  `promo_is_displayed` int(11) NOT NULL DEFAULT '0',
  `review_is_allowed` int(11) NOT NULL DEFAULT '0',
  `pickup_is_allowed` int(11) NOT NULL DEFAULT '1',
  `delivery_note` text COLLATE utf8mb4_unicode_ci,
  `min_order_is_allowed` int(11) NOT NULL DEFAULT '1',
  `flatrate_is_allowed` int(11) NOT NULL DEFAULT '1',
  `delivery_collect_is_allowed` int(11) NOT NULL DEFAULT '1',
  `accepted_payments` text COLLATE utf8mb4_unicode_ci,
  `coupon_limit` int(11) DEFAULT '1',
  `coupon_discount_limit` decimal(16,2) NOT NULL DEFAULT '1000.00',
  `cart_notification_duration` int(11) NOT NULL DEFAULT '0',
  `cart_product_duration` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `contact_us_email_layout` text COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `api_key`, `website_name`, `website_favicon`, `company_logo`, `company_favicon`, `company_name`, `company_about`, `company_address`, `google_analytics`, `google_map`, `google_recaptcha_sitekey`, `google_recaptcha_secret`, `data_privacy_title`, `data_privacy_popup_content`, `data_privacy_content`, `mobile_no`, `fax_no`, `tel_no`, `email`, `social_media_accounts`, `copyright`, `user_id`, `min_order`, `promo_is_displayed`, `review_is_allowed`, `pickup_is_allowed`, `delivery_note`, `min_order_is_allowed`, `flatrate_is_allowed`, `delivery_collect_is_allowed`, `accepted_payments`, `coupon_limit`, `coupon_discount_limit`, `cart_notification_duration`, `cart_product_duration`, `created_at`, `updated_at`, `deleted_at`, `contact_us_email_layout`) VALUES
(1, '', 'PRECIOUS PAGES CORP', 'favicon.ico', '1707185818_webfocus-logo.png', '', 'PRECIOUS PAGES CORP', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Engineering & Sales: 181-C Sunset Drive, Brookside Hills, Brgy. San Isidro, Cainta, Rizal 1900, Philippines', NULL, 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1930.6086602520882!2d121.125328!3d14.586689000000002!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x7d895c3d922926bc!2sExponent%20Controls%20and%20Electrical%20Corporation%20-%20Engineering%20Office!5e0!3m2!1sen!2sph!4v1642996547399!5m2!1sen!2sph', '6Lfgj7cUAAAAAJfCgUcLg4pjlAOddrmRPt86tkQK', '6Lfgj7cUAAAAALOaFTbSFgCXpJldFkG8nFET9eRx', 'Privacy-Policy', 'This website uses cookies to ensure you get the best experience.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '+63 8542-4121', '13232107114', '1800-547-2145', 'ebookstore@phr.com.ph', '', '2023-2024', 1, 0, 0, 0, 1, NULL, 1, 1, 1, NULL, 1, 1000.00, 0, 0, NULL, '2024-02-06 03:33:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

CREATE TABLE `social_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_account` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `subscription_expiry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(16,2) NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `long_description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `is_active` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mobile` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_street` text COLLATE utf8mb4_unicode_ci,
  `address_city` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_municipality` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_province` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` enum('none','facebook','google') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `provider_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `firstname`, `lastname`, `avatar`, `email_verified_at`, `password`, `role_id`, `is_active`, `user_id`, `mobile`, `phone`, `address_street`, `address_city`, `address_municipality`, `address_province`, `address_zip`, `provider`, `provider_id`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'wsiprod.demo@gmail.com', 'Admin', 'Istratorz', NULL, '2024-01-30 06:25:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 1, 1, '09456714321', '022646545', 'Maharlika St', 'Pasay', NULL, NULL, '1234', 'none', NULL, 'zHoqKIZjt9MPDWwo2BB6Q2tsBbCJchRl7ir9txSDqO4Cw4OM5eEETn64lAlw', '2024-01-30 06:25:03', '2024-02-06 03:33:23', NULL),
(2, 'user1', 'user1@gmail.com', 'user1', 'user1', NULL, '2024-01-30 06:25:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 1, 1, '09456714321', '022646545', 'Maharlika St', 'Pasay', NULL, NULL, '1234', 'none', NULL, 'oYDndD0JPr', '2024-01-30 06:25:03', '2024-01-30 06:25:03', NULL),
(3, 'user2', 'user2@gmail.com', 'user2', 'user2', NULL, '2024-01-30 06:25:03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 1, 1, '09456714321', '022646545', 'Maharlika St', 'Pasay', NULL, NULL, '1234', 'none', NULL, '8QEG8tImWu', '2024-01-30 06:25:03', '2024-01-30 06:25:03', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_access_permission_per_role`
-- (See below for the actual view)
--
CREATE TABLE `view_access_permission_per_role` (
`user_id` int(11)
,`role` int(11)
,`permissions` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_role_permission`
-- (See below for the actual view)
--
CREATE TABLE `view_role_permission` (
`user_id` int(11)
,`role` int(11)
,`name` varchar(191)
,`permission_module` varchar(191)
);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure for view `view_access_permission_per_role`
--
DROP TABLE IF EXISTS `view_access_permission_per_role`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webfocus_dev`@`localhost` SQL SECURITY DEFINER VIEW `view_access_permission_per_role`  AS SELECT `view_role_permission`.`user_id` AS `user_id`, `view_role_permission`.`role` AS `role`, group_concat(`view_role_permission`.`name` separator '|') AS `permissions` FROM `view_role_permission` GROUP BY `view_role_permission`.`user_id`, `view_role_permission`.`role` ;

-- --------------------------------------------------------

--
-- Structure for view `view_role_permission`
--
DROP TABLE IF EXISTS `view_role_permission`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webfocus_dev`@`localhost` SQL SECURITY DEFINER VIEW `view_role_permission`  AS SELECT `role_permission`.`user_id` AS `user_id`, `role_permission`.`role_id` AS `role`, `permission`.`name` AS `name`, `permission`.`module` AS `permission_module` FROM (`role_permission` join `permission` on((`role_permission`.`permission_id` = `permission`.`id`))) WHERE (`role_permission`.`isAllowed` = 1) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`);

--
-- Indexes for table `article_categories`
--
ALTER TABLE `article_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_activity_logs`
--
ALTER TABLE `cms_activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_cart`
--
ALTER TABLE `coupon_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_cart_temp_discount`
--
ALTER TABLE `coupon_cart_temp_discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_sales`
--
ALTER TABLE `coupon_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_coupons`
--
ALTER TABLE `customer_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_favorites`
--
ALTER TABLE `customer_favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_libraries`
--
ALTER TABLE `customer_libraries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliverable_cities`
--
ALTER TABLE `deliverable_cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecommerce_delivery_status`
--
ALTER TABLE `ecommerce_delivery_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecommerce_sales_details`
--
ALTER TABLE `ecommerce_sales_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecommerce_sales_headers`
--
ALTER TABLE `ecommerce_sales_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecommerce_sales_payments`
--
ALTER TABLE `ecommerce_sales_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecommerce_shopping_cart`
--
ALTER TABLE `ecommerce_shopping_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecredits`
--
ALTER TABLE `ecredits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_recipients`
--
ALTER TABLE `email_recipients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_attributes`
--
ALTER TABLE `form_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_receiver_details`
--
ALTER TABLE `inventory_receiver_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_receiver_header`
--
ALTER TABLE `inventory_receiver_header`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus_has_pages`
--
ALTER TABLE `menus_has_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `paynamics_logs`
--
ALTER TABLE `paynamics_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_additional_infos`
--
ALTER TABLE `product_additional_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_photos`
--
ALTER TABLE `product_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promo_products`
--
ALTER TABLE `promo_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media`
--
ALTER TABLE `social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `article_categories`
--
ALTER TABLE `article_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_activity_logs`
--
ALTER TABLE `cms_activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon_cart`
--
ALTER TABLE `coupon_cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_cart_temp_discount`
--
ALTER TABLE `coupon_cart_temp_discount`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_sales`
--
ALTER TABLE `coupon_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_coupons`
--
ALTER TABLE `customer_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_favorites`
--
ALTER TABLE `customer_favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_libraries`
--
ALTER TABLE `customer_libraries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deliverable_cities`
--
ALTER TABLE `deliverable_cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ecommerce_delivery_status`
--
ALTER TABLE `ecommerce_delivery_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ecommerce_sales_details`
--
ALTER TABLE `ecommerce_sales_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ecommerce_sales_headers`
--
ALTER TABLE `ecommerce_sales_headers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ecommerce_sales_payments`
--
ALTER TABLE `ecommerce_sales_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ecommerce_shopping_cart`
--
ALTER TABLE `ecommerce_shopping_cart`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ecredits`
--
ALTER TABLE `ecredits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_recipients`
--
ALTER TABLE `email_recipients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_attributes`
--
ALTER TABLE `form_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_receiver_details`
--
ALTER TABLE `inventory_receiver_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `inventory_receiver_header`
--
ALTER TABLE `inventory_receiver_header`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menus_has_pages`
--
ALTER TABLE `menus_has_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `paynamics_logs`
--
ALTER TABLE `paynamics_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_additional_infos`
--
ALTER TABLE `product_additional_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_photos`
--
ALTER TABLE `product_photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_tags`
--
ALTER TABLE `product_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promo_products`
--
ALTER TABLE `promo_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `social_media`
--
ALTER TABLE `social_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
