Joomla! CMS™ [![Analytics](https://ga-beacon.appspot.com/UA-544070-3/joomla-cms/readme)](https://github.com/igrigorik/ga-beacon) [![Reviewed by Hound](https://img.shields.io/badge/Reviewed_by-Hound-8E64B0.svg)](https://houndci.com)
====================

Build Status
---------------------
| Drone-CI | AppVeyor |
| ------------- | ------------- |
| [![Build Status](https://ci.joomla.org/api/badges/joomla/joomla-cms/status.svg?branch=4.0-dev)](https://ci.joomla.org/joomla/joomla-cms)  | [![Build status](https://ci.appveyor.com/api/projects/status/ru6sxal8jmfckvjc/branch/4.0-dev?svg=true)](https://ci.appveyor.com/project/release-joomla/joomla-cms)  |

What is this?
---------------------
* This is the source of Joomla! 4.x. "khonsu" alternate template development
* Styleguide(https://delowar.gitbook.io/joomla-elements/)
* Detailed changes are in the [changelog](https://github.com/joomla-projects/j4adminui/commits).

How to get a working installation from the source
---------------------
For detailed instructions please visit https://docs.joomla.org/J4.x:Setting_Up_Your_Local_Environment

You will need:
- PHP - basically the same as you need for running a Joomla Site, but you need the cli (command line interface) Version (see https://docs.joomla.org/Configuring_a_LAMPP_server_for_PHP_development)
- Composer - for managing Joomla's PHP Dependencies. For help installing composer please read the documentation at https://getcomposer.org/doc/00-intro.md
- Node.js - for compiling Joomla's Javascript and SASS files. For help installing Node.js please follow the instructions available on https://nodejs.org/en/
- Git - for version management. Download from here https://git-scm.com/downloads (MacOS users can also use Brew and Linux users can use the built-in package manager, eg apt, yum, etc). 

**Steps to setup the local environment:**
- Clone the repository:
```bash
git clone git@github.com:joomla-projects/j4adminui.git
```
- Go to the j4adminui folder:
```bash
cd j4adminui
```
- Install all the needed composer packages:
```bash
composer install
```
- Install all the needed npm packages:
```bash
npm ci install
```

Backstory
=========================
This repository represents a much apreciated cummunity initiative for an alternate backend template for Joomla4! Endorsing it in now way disqualifies or degrades the existing "atum" template and the team that created it. ["In matters of taste, there can be no disputes"](https://en.wikipedia.org/wiki/De_gustibus_non_est_disputandum). 

History
----------------------
This project started as an initiative by [Kawshar Ahmed](https://www.facebook.com/jkawshar) on facebook as a community initiative that got endorsed by the Joomla production department.
The inititiation post of august can be found [here](https://www.facebook.com/groups/joomlanospam/permalink/10156182532445997/). Production department thought it important to communicate from the very start that this initiative was subject to the same rules and requirements as all code before accepting into core distribution. The exection being that the initiators are also responsible for support.
The following sections is a verbatum copy of the initial response to the initiave as can be found in the above FB message thread.

Formalities / requirements
--------------------------
Thank you for your design proposals!, We, the Production Team welcome every initiative of Joomlers, our user base, to contribute. In this case in the form of an alternative Back End (BE) template. Any alternative will be held to the same standards and requirements as the current template, no more, no less.

### initial top level requirements. The template shall:
* be responsive, meaning it has to work on all screen sizes and supported browsers
* ensure AA, WCAG 2.1 compliant accessibility ( color schemes, keyboard navigation)
* ensure b/c for 3party extensions
* support all of functionality as current BE template does ( to name a few: new mediamanager, workflow, dashboards ...)
* have menus that must be "editable"/"manageable" via the menu manager
* not include no jquery or other JS-frameworks (all native ES6)
* not introduce any Backward Compatibility (BC) breaking functionality to the backend after the release of Beta J4
* provide full layout and template overrides support
* comply with coding standards
* have a maintenance plan

Staffing the project ( during both creation and maintenance) is the responsibility of the team taking the initiative. Unfortunately Production Department is short on staff for completing J4 as is. Production Department will liaise to ensure best possible communication between teams.

Production will come up with a full list that the current admin template is required to adhere to. The above is an initial list, the final list will encompass this list but not necessarily be limited to that list.
The above mentioned list might be amended as the development of Joomla 4 continues.

A new/alternative template must comply with all of the set out requirements and have undergone thorough testing on all aspects.
If all of the requirements are met Production intends to include it as part of the core distribution.

The moment of inclusion will be dependant on the speed of development. The release of J4 will not be postponed/delayed. In case the time-frame can not be met, inclusion could take place in a subsequent minor release (J4.1?)

Thank you for all your commitment to make Joomla 4 great!

### additions / modifications to top level requirements
* Support for Left to Right (LTR) languages 

Joomla! CMS v4.0 in general
=========================
visit  https://github.com/joomla/joomla-cms and switch to the https://launch.joomla.org/

Copyright
---------------------
* Copyright (C) 2005 - 2019 Open Source Matters. All rights reserved.
* Distributed under the GNU General Public License version 2 or later
* See [License details](https://docs.joomla.org/Special:MyLanguage/Joomla_Licenses)
