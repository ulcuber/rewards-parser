import qs from 'qs';
import axios from 'axios';

const token = document.head.querySelector('meta[name="csrf-token"]').content;

const client = axios.create({
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': token,
  },
});

export default {
  get(url, params) {
    return this.send('get', url, params);
  },
  post(url, params) {
    return this.send('post', url, params);
  },
  put(url, params) {
    return this.send('put', url, params);
  },
  delete(url, params) {
    return this.send('delete', url, params);
  },
  send(method, url, params = {}) {
    return client({
      method,
      url,
      data: params,
      params: method === 'get' || method === 'delete' ? params : {},
      paramsSerializer(serializerParams) {
        return qs.stringify(serializerParams, { arrayFormat: 'brackets' });
      },
    });
  },
  all(...promises) {
    return new Promise(((resolve) => {
      client.all(promises).then(client.spread(() => {
        resolve();
      }));
    }));
  },
};
