import { extend } from 'flarum/extend';
import app from 'flarum/app';
import LogInButtons from 'flarum/components/LogInButtons';
import LogInButton from 'flarum/components/LogInButton';

app.initializers.add('dem13n-auth-vkontakte', () => {
  extend(LogInButtons.prototype, 'items', function(items) {
    items.add('vkontakte',
      <LogInButton
        className="Button LogInButton--vkontakte"
        icon="fab fa-vk"
        path = "/auth/vkontakte" >
        {app.translator.trans('dem13n-auth-vkontakte.forum.login_with_vkontakte_button')}
      </LogInButton>
    );
  });
});
