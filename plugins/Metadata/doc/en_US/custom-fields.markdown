Category and Custom Fields
==========================

This plugin provides category fields for a task that are added depending on task's Category.

Custom Fields
---------------

Custom fields can be added independently.


Category Fields
---------------

If a Category for a task is changed, only Custom Fields relevant for this category are displayed in task's Summary.


To enable Category Fields, you have to:

1. Add some Categories for the project
2. Add project metadata fields for creating task's Custom Fields


Adding Categories for the project
---------------------------------

In a project, select project **Menu** (top-left corner) | **Settings** | **Categories**.

Add some categories here.


Adding project metadata for task's Custom Fields
------------------------------------------------

Custom Field definitions are added in project Metadata:

In a project, select project **Menu** (top-left corner) | **Settings** | **Metadata**.

In order for a **Category** field to be always added to a task if missing, you have to prefix the field name with category name and underscore.

E.g if you want field **GitCommit** field to be added to a task by default for a category **Dev**, you have to define it as **Dev_GitCommit**:

![Custom fields definition](screenshots/custom-fields-def.png)
