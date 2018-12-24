import Echo from 'laravel-echo';
import client from 'socket.io-client';

const echo = new Echo({
  broadcaster: 'socket.io',
  host: `${window.location.hostname}:6001`,
  client,
});

export default echo;
