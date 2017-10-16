# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 2.2.0 - 2017-10-16

- Add provider for Amazon SES for sending RenderedMail and TemplatedMail

## 2.1.0 - 2017-07-22

- Updated the container to use PSR interface.
- `send` method now can now returns a message ID from the underlying provider. This can be useful if you need to
  save into your database a message ID coming from the mail provider. Postmark mailer has been updated to return this.

## 2.0.0 - 2016-06-16

- [BC] `ModuleConfig` has been replaced by `ConfigProvider` and is now compatible with [Zend\ComponentInstaller](https://zendframework.github.io/zend-component-installer/)

## 1.0.0 - 2016-02-29

- Initial release.
