let baseUrl = '';

if (!process.env.NODE_ENV || process.env.NODE_ENV === 'development') {
  baseUrl = 'http://localhost:84';
}

export default class RestApiClient {
  static index() {
    return fetch(`${baseUrl}/api/products`, {method: 'GET'});
  }

  static create(body) {
    return fetch(`${baseUrl}/api/products`, {method: 'POST', body});
  }

  static delete(body) {
    return fetch(
      `${baseUrl}/api/products/delete`,
      {method: 'POST', body, headers: {"Content-Type": "application/json"}}
    );
  }
}