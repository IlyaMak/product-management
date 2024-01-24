import RestApiClient from "../services/RestApiClient";
import {useState} from "react";

const EMPTY_ERROR_MESSAGE = 'Please, submit required data';
const TYPE_ERROR_MESSAGE = 'Please, provide the data of indicated type';

const validatorsByEmptyValue = {
  dvd: (formData) => formData.get('size').length === 0,
  furniture: (formData) => {
    return formData.get('height').length === 0
      || formData.get('width').length === 0
      || formData.get('length').length === 0;
  },
  book: (formData) => formData.get('weight').length === 0
}
const validatorsByTypeValue = {
  dvd: (formData) => isNaN(parseInt(formData.get('size'))),
  furniture: (formData) => {
    return isNaN(parseInt(formData.get('height')))
      || isNaN(parseInt(formData.get('width')))
      || isNaN(parseInt(formData.get('length')));
  },
  book: (formData) => isNaN(parseInt(formData.get('weight')))
}

const typeContent = {
  'dvd': <div>
    Size (MB) <input id="size" type="text" name="size"/>
    <div>Please, provide disk size in MB</div>
  </div>,
  'furniture': <div>
    Height (CM) <input id="height" type="text" name="height"/>
    Width (CM) <input id="width" type="text" name="width"/>
    Length (CM) <input id="length" type="text" name="length"/>
    <div>Please, provide furniture dimensions in CM</div>
  </div>,
  'book': <div>
    Weight (KG) <input id="weight" type="text" name="weight"/>
    <div>Please, provide book weight in KG</div>
  </div>
}

export default function AddNew() {
  const [type, setType] = useState('');
  const [errorMessage, setErrorMessage] = useState('');

  function handleSubmit(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const price = formData.get('price');
    setErrorMessage('');

    if (
      formData.get('sku').length === 0
      || formData.get('name').length === 0
      || price.length === 0
      || type.length === 0
      || validatorsByEmptyValue[type](formData)
    ) {
      setErrorMessage(EMPTY_ERROR_MESSAGE);
      return;
    }
    if (isNaN(parseFloat(price.toString())) || validatorsByTypeValue[type](formData)) {
      setErrorMessage(TYPE_ERROR_MESSAGE);
      return;
    }

    RestApiClient.create(formData)
      .then(async (response) => {
        const json = await response.json();
        if (response.ok) {
          window.location.pathname = '/';
          return;
        }
        setErrorMessage(json.message);
      })
  }

  return (
    <form id="product_form" onSubmit={handleSubmit} method="post">
      <h1>Product Add</h1>
      <button type="submit">Save</button>
      <a href="/">Cancel</a>
      <hr/>
      SKU <input id="sku" type="text" name="sku"/>
      Name <input id="name" type="text" name="name"/>
      Price ($) <input id="price" type="text" name="price"/>
      <select id="productType" name="type" value={type} onChange={(e) => setType(e.target.value)}>
        <option value="">Type Switcher</option>
        <option value="dvd">DVD</option>
        <option value="furniture">Furniture</option>
        <option value="book">Book</option>
      </select>
      {typeContent[type]}
      <span>{errorMessage}</span>
    </form>
  );
}
