import RestApiClient from '../services/RestApiClient';
import {useState} from 'react';
import './AddNew.scss';
import Footer from '../components/Footer/Footer';

const emptyErrorMessage = 'Please, submit required data';
const typeErrorMessage = 'Please, provide the data of indicated type';

const validatorsByEmptyValue = {
  dvd: (formData) => formData.get('size').length === 0,
  furniture: (formData) => {
    return formData.get('height').length === 0
      || formData.get('width').length === 0
      || formData.get('length').length === 0;
  },
  book: (formData) => formData.get('weight').length === 0
};
const validatorsByTypeValue = {
  dvd: (formData) => isNaN(parseInt(formData.get('size'))),
  furniture: (formData) => {
    return isNaN(parseInt(formData.get('height')))
      || isNaN(parseInt(formData.get('width')))
      || isNaN(parseInt(formData.get('length')));
  },
  book: (formData) => isNaN(parseInt(formData.get('weight')))
};

const typeContent = {
  'dvd': <div className="special-attribute-section">
    <div className="input-section">
      <label className="label" htmlFor="size">Size (MB)</label>
      <input id="size" className="input-container" type="text" name="size"/>
    </div>
    <div className="product-description">
      Please, provide disk size in MB
    </div>
  </div>,
  'furniture': <div className="special-attribute-section">
    <div className="input-section">
      <label className="label" htmlFor="height">Height (CM)</label>
      <input id="height" className="input-container" type="text" name="height"/>
    </div>
    <div className="input-section">
      <label className="label" htmlFor="width">Width (CM)</label>
      <input id="width" className="input-container" type="text" name="width"/>
    </div>
    <div className="input-section">
      <label className="label" htmlFor="length">Length (CM)</label>
      <input id="length" className="input-container" type="text" name="length"/>
    </div>
    <div className="product-description">
      Please, provide furniture dimensions in CM
    </div>
  </div>,
  'book': <div className="special-attribute-section">
    <div className="input-section">
      <label className="label" htmlFor="weight">Weight (KG)</label>
      <input id="weight" className="input-container" type="text" name="weight"/>
    </div>
    <div className="product-description">
      Please, provide book weight in KG
    </div>
  </div>
};

export default function AddNew() {
  const [type, setType] = useState('');
  const [errorMessage, setErrorMessage] = useState('');

  function handleSubmit(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const price = formData.get('price');
    setErrorMessage('');

    if (
      formData.get('sku').trim().length === 0
      || formData.get('name').trim().length === 0
      || price.length === 0
      || type.length === 0
      || validatorsByEmptyValue[type](formData)
    ) {
      setErrorMessage(emptyErrorMessage);
      return;
    }
    if (isNaN(parseFloat(price.toString())) || validatorsByTypeValue[type](formData)) {
      setErrorMessage(typeErrorMessage);
    }

    RestApiClient.create(formData)
      .then(async (response) => {
        const json = await response.json();
        if (response.ok) {
          window.location.pathname = '/';
          return;
        }
        setErrorMessage(json.message);
      });
  }

  return (
    <div className="main-container">
      <form id="product_form" onSubmit={handleSubmit} method="post">
        <div className="header-container">
          <h1>Product Add</h1>
          <div className="actions-container">
            <button className="button button--success" type="submit">
              Save
            </button>
            <a className="button button--danger" href="/">
              Cancel
            </a>
          </div>
        </div>
        <hr/>
        <div className="form-section">
          <div className="input-section">
            <label className="label" htmlFor="sku">SKU</label>
            <input id="sku" className="input-container" type="text" name="sku"/>
          </div>
          <div className="input-section">
            <label className="label" htmlFor="name">Name</label>
            <input id="name" className="input-container" type="text" name="name"/>
          </div>
          <div className="input-section">
            <label className="label" htmlFor="price">Price ($)</label>
            <input id="price" className="input-container" type="text" name="price"/>
          </div>
          <div className="input-section">
            <label className="label" htmlFor="productType">Type Switcher</label>
            <select id="productType" className="input-container input-container--selector" name="type" value={type}
                    onChange={(e) => setType(e.target.value)}>
              <option value="">Type Switcher</option>
              <option value="dvd">DVD</option>
              <option value="furniture">Furniture</option>
              <option value="book">Book</option>
            </select>
          </div>
          {typeContent[type]}
          <div className="error-content">{errorMessage}</div>
        </div>
      </form>
      <Footer/>
    </div>
  );
}
