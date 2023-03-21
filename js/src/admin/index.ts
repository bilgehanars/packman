
import app from 'flarum/app';

import PackManPage from './components/PackManPage';

app.initializers.add('bilgehanars-packman', () => {
  app.extensionData
    .for('bilgehanars-packman')
    .registerPage(PackManPage);
  });

