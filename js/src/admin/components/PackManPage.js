import ExtensionPage from 'flarum/admin/components/ExtensionPage';
import Button from 'flarum/common/components/Button';
import Alert from 'flarum/common/components/Alert';

export default class PackManPage extends ExtensionPage {
  oninit(vnode) {
    super.oninit(vnode);
    this.komut = '';
    this.packadi = '';
    this.output = '';
    app
      .request({
        method: 'post',
        url: app.forum.attribute('apiUrl') + '/packman',
        timeout: 100000,
        body: {
          komut: 'prohibits',
          packadi: '',
        },
      })
      .then((result) => {
        // ok işareti ile tanımlanan fonksiyon
        console.log(result);
        this.output = ' REQUIRED PACKAGES\n';
        this.output += result;
        m.redraw();
      });
  }

  content() {
    return (
      <div className={'container'}>
        <Alert>
          {' '}
          While the page is loading, PackMan will automatically print the applications that are required by composer for flarum. It may take a minute.{' '}
        </Alert>
        <form onsubmit={this.onsubmit.bind(this)}>
          Composer Command - Require/Update/Remove <br />
          <input className="FormControl" value={this.komut} oninput={(e) => (this.komut = e.target.value)}></input> <br />
          Package Name (Example: Bilgehanars/PackMan)
          <br />
          <input className="FormControl" value={this.packadi} oninput={(e) => (this.packadi = e.target.value)}></input> <br />
          <Button id="execute-button" type="submit">
            Execute
          </Button>
        </form>
        {m('div', [this.output !== '' && m('div.PackManPage-output', m('pre', this.output))])}
      </div>
    );
  }

  onsubmit(e) {
    var button = document.getElementById('execute-button');
    button.disabled = true;
    e.preventDefault();
    app
      .request({
        method: 'post',
        url: app.forum.attribute('apiUrl') + '/packman',
        timeout: 100000,
        body: {
          komut: this.komut,
          packadi: this.packadi,
        },
      })
      .then((result) => {
        // ok işareti ile tanımlanan fonksiyon
        button.disabled = false;
        console.log(result);
        this.output = '------OUTPUT------\n';
        this.output += result + '\n------OUTPUT END------';

        m.redraw();
      });
  }
}
/// composer prohibits flarum/core *
