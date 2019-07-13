import app from 'flarum/app';

import VkontakteSettingsModal from './components/VkontakteSettingsModal';

app.initializers.add('dem13n-auth-vkontakte', () => {
  app.extensionSettings['dem13n-auth-vkontakte'] = () => app.modal.show(new VkontakteSettingsModal());
});
