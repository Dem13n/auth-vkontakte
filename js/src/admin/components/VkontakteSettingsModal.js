import SettingsModal from 'flarum/components/SettingsModal';

export default class VkontakteSettingsModal extends SettingsModal {
  className() {
    return 'VkontakteSettingsModal Modal--small';
  }

  title() {
    return app.translator.trans('dem13n-auth-vkontakte.admin.vkontakte_settings.title');
  }

  form() {
    return [
      <div className="Form-group">
        <label>{app.translator.trans('dem13n-auth-vkontakte.admin.vkontakte_settings.app_desc', { a: <a href="https://vk.com/apps?act=manage" target="_blank" /> })}</label>
        <label>{app.translator.trans("dem13n-auth-vkontakte.admin.vkontakte_settings.app_p")}</label>
        <b>{document.location.origin + "/auth/vkontakte"}</b>
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('dem13n-auth-vkontakte.admin.vkontakte_settings.app_id_label')}</label>
        <input className="FormControl" bidi={this.setting('dem13n-auth-vkontakte.app_id')} />
      </div>,

      <div className="Form-group">
        <label>{app.translator.trans('dem13n-auth-vkontakte.admin.vkontakte_settings.app_key_label')}</label>
        <input className="FormControl" bidi={this.setting('dem13n-auth-vkontakte.app_key')} />
      </div>
    ];
  }
}
