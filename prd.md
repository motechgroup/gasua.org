This is an excellent project, and it can become much more than a simple website. If designed well, **Gusii All Stars Foundation** can become a complete fundraising and charity management platform similar to GoFundMe, GlobalGiving, or JustGiving, but customized for Kenya and Africa.

I recommend building it as a **Foundation Management System (FMS)** rather than just a website.

---

# GUSII ALL STARS FOUNDATION

## Product Requirements Document (PRD)

### Project Name

**Gusii All Stars Foundation Management System**

---

# Vision

Develop a modern, secure, scalable charity and fundraising platform that enables Gusii All Stars Foundation to:

* Showcase their impact
* Organize charity activities
* Nurture talents
* Raise funds online
* Receive donations worldwide
* Increase transparency
* Manage volunteers
* Publish success stories
* Generate campaign links for fundraising

---

# Objectives

The platform should enable the foundation to:

* Promote talents
* Organize charity events
* Feed the needy
* Build schools/community projects
* Sponsor education
* Raise emergency funds
* Receive donations globally
* Accept recurring donations
* Publish financial transparency

---

# User Roles

## 1. Super Admin

Can

* Manage everything
* Manage users
* Manage campaigns
* Manage donations
* Manage payment gateways
* Manage website settings
* Generate reports
* Export reports
* View analytics
* Moderate comments
* Send newsletters

---

## 2. Campaign Manager

Can

* Create fundraising campaigns
* Upload campaign images/videos
* Update campaign progress
* Reply to donor messages

Cannot

* Access financial settings
* Access payment gateways

---

## 3. Content Manager

Can

* Publish news
* Upload gallery
* Manage talents
* Publish blogs
* Manage testimonials

---

## 4. Finance Officer

Can

* View donations
* Export financial reports
* Confirm offline donations
* Manage refunds

---

## 5. Volunteer Coordinator

Can

* Manage volunteers
* Approve volunteer applications
* Assign volunteers to events

---

## Public Visitors

Can

* Browse website
* View campaigns
* Donate
* Register as volunteer
* Contact foundation
* Subscribe to newsletter
* Share campaigns

---

# Public Website

## Home Page

Hero Banner

* Large background video
* Foundation slogan
* Donate button
* Become Volunteer
* Upcoming Events

Sections

* About Foundation
* Vision
* Mission
* Impact Statistics

Example

* Meals Served
* Children Sponsored
* Trees Planted
* Talents Supported
* Projects Completed

Latest Campaigns

Latest News

Upcoming Events

Gallery

Testimonials

Partners

Sponsors

Newsletter

Footer

---

# About Us

* History
* Mission
* Vision
* Core Values
* Leadership
* Team

---

# Our Programs

Talent Development

* Football
* Athletics
* Music
* Dance
* Drama
* Education

Community Projects

* Feeding Program
* Education Support
* Health Camps
* Youth Empowerment
* Women Empowerment

---

# Campaigns

Each campaign contains

* Title
* Banner
* Gallery
* Goal Amount
* Amount Raised
* Remaining Amount
* Number of Donors
* Start Date
* End Date
* Description
* Updates
* Comments
* Share Buttons

Donate Button

Progress Bar

Donation History

Recent Donors

Anonymous Donations

Campaign Organizer

---

# Events

Admin creates

* Charity Walk
* Football Tournament
* Talent Search
* Feeding Event
* Medical Camp

Each event contains

* Images
* Videos
* Ticket (optional)
* Donation Target
* Countdown
* Location
* Google Maps

---

# Talent Section

Categories

Football

Music

Dance

Poetry

Comedy

Drama

Models

Each profile includes

* Photos
* Videos
* Biography
* Awards
* Social Media
* Sponsors

---

# News

Blogs

Success Stories

Announcements

Press Releases

---

# Gallery

Albums

Videos

Photos

YouTube Integration

---

# Volunteer System

Volunteer Registration

Fields

* Name
* Email
* Phone
* Skills
* County
* Availability

Admin

Approve

Reject

Assign Event

---

# Donations

Donation Types

One-time

Monthly

Yearly

Anonymous

Dedicated

Memorial

Emergency

---

# Donation Checkout

Information

Name

Email

Phone

Country

Message

Anonymous Option

Gift Aid (future)

Receipt Email

---

# Payment Gateways

Admin can Enable/Disable individually.

### MPesa

Safaricom Daraja API

STK Push

Paybill

Till Number

---

### Flutterwave

Supports

* Cards
* Mobile Money
* Bank Transfer
* Airtel Money
* MTN
* Orange Money

Excellent for Africa.

---

### DPO Pay

East Africa

Cards

Banks

Mobile Money

---

### PayPal

Worldwide

---

### Stripe (optional)

Cards

Apple Pay

Google Pay

Recommended for international donors.

---

# Cryptocurrency Gateway

I recommend **NOWPayments**.

Why?

✔ Easy API

✔ No KYC for your website

✔ Supports 300+ cryptocurrencies

✔ Auto conversion

✔ Webhooks

✔ Donation widgets

✔ Stablecoin support

Supports

* Bitcoin
* Ethereum
* Litecoin
* Solana
* USDT
* USDC
* BNB
* XRP

Alternative

* Coinbase Commerce
* CoinGate
* BTCPay Server (self-hosted, no transaction fees)

**Recommendation:** **NOWPayments** offers the best balance of ease of integration and broad crypto support for a foundation.

---

# Smart Fundraising Links

Admin clicks

Create Fundraiser

Example

```
Feed 500 Families
```

System generates

```
gusiiallstars.org/fundraise/feed500
```

or

```
gusiiallstars.org/donate/feed500
```

Can customize

* URL
* Goal
* Description
* Cover Photo
* Expiry

Share

Facebook

WhatsApp

Instagram

Twitter

LinkedIn

Email

QR Code

---

# Peer-to-Peer Fundraising

A supporter can

Create Personal Fundraiser

Example

John wants birthday donations instead of gifts.

Creates

```
Donate instead of gifts

Goal:
KES 100,000
```

Shares with friends.

Funds go directly to foundation.

---

# Donation Receipts

Automatic

PDF Receipt

Email

SMS

Reference Number

QR Verification

---

# Transparency Dashboard

Public

Money Raised

Projects Funded

Meals Served

Children Supported

Expenses (optional)

Financial Reports

Annual Reports

Audited Statements

---

# Admin Dashboard

Statistics

Today's Donations

Monthly Donations

Campaigns

Events

Visitors

Conversion Rate

Active Volunteers

Pending Donations

Charts

Recent Activities

---

# Reports

Donations

Campaign Performance

Events

Volunteers

Payments

Export

PDF

Excel

CSV

---

# CMS

Editable

Homepage

About

Programs

Gallery

Footer

FAQs

Contact

Privacy Policy

Terms

---

# SEO

Meta Titles

Meta Descriptions

Schema.org

Open Graph

Twitter Cards

XML Sitemap

robots.txt

Canonical URLs

Google Analytics

Google Tag Manager

Meta Pixel

---

# Security

Google reCAPTCHA

Cloudflare Turnstile

2FA for Admin

CSRF Protection

Rate Limiting

Audit Logs

Encrypted Payment Credentials

Role Permissions

Activity Logs

---

# Notifications

Email

SMS

WhatsApp (optional)

Push Notifications

---

# Technology Stack

Backend

Laravel 12

Frontend

Livewire 3

TailwindCSS 4

Database

MySQL 8

Queue

Redis

Storage

AWS S3 / DigitalOcean Spaces

Payments

* MPesa Daraja
* Flutterwave
* DPO Pay
* PayPal
* NOWPayments (Crypto)

Email

Brevo

Mailgun

Amazon SES

SMS

Africa's Talking

Twilio

TextSMS Kenya

Hosting

Ubuntu VPS

Nginx

PHP 8.4

Redis

Supervisor

Cloudflare

---

# Future Features

* AI-powered donation recommendations
* AI chatbot
* Multi-language (English, Kiswahili, Ekegusii)
* Donor accounts with dashboards
* Membership subscriptions
* Corporate sponsorship portal
* Grant application management
* Beneficiary management
* Inventory and relief distribution tracking
* Mobile app (Flutter)

---

# MASTER PROMPT FOR AI CODING AGENT

```text
You are a senior Laravel architect, UI/UX designer, DevOps engineer, payment integration expert, and cybersecurity specialist.

Build a production-ready Foundation Management System called "Gusii All Stars Foundation."

Tech Stack:
- Laravel 12
- PHP 8.4+
- Livewire 3
- Tailwind CSS 4
- MySQL 8
- Alpine.js
- Redis Queues
- Laravel Scheduler
- Spatie Laravel Permission
- Spatie Media Library
- Laravel Cashier where applicable
- RESTful architecture
- Responsive mobile-first design
- SEO optimized
- Dark/Light mode
- PWA ready

Create a modern, premium charity platform comparable to GlobalGiving, GoFundMe, and JustGiving.

Core Modules:
1. Homepage CMS
2. About Foundation
3. Programs
4. Talent Development
5. Events Management
6. Fundraising Campaigns
7. Peer-to-Peer Fundraising
8. Donation Management
9. Volunteer Management
10. News & Blog
11. Gallery (Photos & Videos)
12. Testimonials
13. Partners & Sponsors
14. Newsletter
15. Contact System
16. Financial Reports
17. Public Transparency Dashboard
18. Analytics Dashboard
19. User & Role Management (RBAC)
20. Settings & CMS

Donation Features:
- One-time donations
- Monthly recurring donations
- Annual recurring donations
- Anonymous donations
- Memorial donations
- Campaign-specific donations
- General donations
- Custom donation amounts
- Donation receipts (PDF & Email)
- QR code verification
- Donor dashboard
- Donation history
- Campaign progress bars
- Real-time fundraising statistics

Payment Gateways:
- Safaricom M-Pesa Daraja API
- Flutterwave
- DPO Pay
- PayPal
- NOWPayments (Crypto)

The administrator must be able to:
- Enable or disable any payment gateway independently.
- Configure API credentials from the admin panel.
- Set a default payment gateway.
- Enable test or live mode.
- View payment logs and webhook logs.
- Retry failed webhook events.

Fundraising:
- Create unlimited fundraising campaigns.
- Generate unique shareable fundraising URLs.
- Generate QR codes for every campaign.
- Social sharing for Facebook, WhatsApp, X, LinkedIn, and Email.
- Support campaign updates, comments, donor messages, and progress tracking.

Admin Dashboard:
Include real-time charts, donation analytics, campaign performance, volunteer statistics, event attendance, recent donations, system health, and audit logs.

Security:
Implement RBAC using Spatie Permissions, two-factor authentication, encrypted API credentials, CSRF protection, rate limiting, activity logging, secure webhooks, and validation on all forms.

SEO:
Generate SEO-friendly URLs, XML sitemaps, robots.txt, Open Graph tags, Twitter Cards, structured Schema.org data, canonical URLs, and meta management.

Performance:
Use eager loading, queues, caching, lazy loading, image optimization, and Laravel best practices. Aim for Lighthouse scores above 90 on Performance, Accessibility, Best Practices, and SEO.

Coding Standards:
- PSR-12 compliant
- SOLID principles
- Repository + Service pattern
- Feature-based architecture
- Comprehensive PHPUnit/Pest tests
- API documentation
- Clean UI with reusable Livewire components

Deliver the project in logical phases:
1. Database architecture and ERD
2. Authentication and RBAC
3. CMS
4. Donation system
5. Payment gateway integrations
6. Fundraising module
7. Events
8. Volunteer management
9. Reporting and analytics
10. Final testing, optimization, deployment, and documentation

The application should be scalable, secure, multilingual-ready, and capable of supporting thousands of concurrent donors and campaigns.
```

This specification gives your AI coding agent enough detail to produce a professional, enterprise-grade platform rather than a basic charity website.
