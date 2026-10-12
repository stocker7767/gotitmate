# GOTITMATE WordPress Theme v1.0.0

This is the WordPress/PHP conversion of the GOTITMATE Phase 30 business architecture.

## What it does
- Fresh GOTITMATE Customer / Provider / Admin roles and capabilities.
- Fresh custom database tables (no ACF dependency, no old CPT dependency).
- Provider applications and verification status.
- Five service families: Plumbing, Electrician, Carpenter, Car Mobile Service, Beautician.
- VJI email OTP for job intent.
- Provider matching with Outcome Intelligence adjustment after sufficient verified history.
- Structured service/material estimates.
- Stripe Checkout for initial service payment and approved service top-ups.
- Stripe webhook verification.
- Stripe Connect Express onboarding and Admin-controlled transfer release.
- Materials Transparency with private invoice storage and local invoice-intelligence rules/optional UK benchmark file.
- Additional work / top-up flow.
- Service Transaction Assurance (STA).
- Dynamic Job Risk.
- Outcome Intelligence.
- Customer-only disputes, Provider response, Admin resolution, Stripe refunds.
- Private-file storage and baseline response/security hardening.

## Important
This theme does not use the old GOTITMATE CPTs, ACF fields, Stripe integration, or old role structure. It creates its own fresh data layer on activation.

## Required wp-config.php settings
Copy the values from `wp-config-example.php` into wp-config.php and fill in your Stripe Test Mode keys before testing payments.

## Stripe webhook
Configure Stripe Test Mode webhook to:
`https://YOUR-DOMAIN/wp-json/gotitmate/v1/stripe/webhook`

Events needed initially:
- `checkout.session.completed`
- `account.updated`

## Installation
1. Back up the WordPress site/database.
2. WordPress Admin > Appearance > Themes > Add New > Upload Theme.
3. Upload `gotitmate.zip` and activate it.
4. Activation creates the fresh GOTITMATE tables, roles and application pages.
5. Add the wp-config constants.
6. Configure Stripe Test Mode webhook.
7. Test the complete journey before switching anything to production.

## Environment boundary
PHP lint/static checks can be performed outside WordPress, but real DB creation, wp_mail, sessions, browser forms, Stripe Checkout/webhooks/Connect and private-file access must be tested on a WordPress staging site.
