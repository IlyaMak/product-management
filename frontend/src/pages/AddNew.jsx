import RestApiClient from "../services/RestApiClient";
import {useState} from "react";

function handleSubmit(e) {
  e.preventDefault();
  const formData = new FormData(e.target);
  RestApiClient.create(formData).then(() => window.location.pathname = '/');
}

const typeContent = {
  'dvd': <div>
    Size (MB) <input id="size" type="number" name="size"/>
    <div>Please, provide disk size in MB</div>
  </div>,
  'furniture': <div>
    Height (CM) <input id="height" type="number" name="height"/>
    Width (CM) <input id="width" type="number" name="width"/>
    Length (CM) <input id="length" type="number" name="length"/>
    <div>Please, provide furniture dimensions in CM</div>
  </div>,
  'book': <div>
    Weight (KG) <input id="weight" type="number" name="weight"/>
    <div>Please, provide book weight in KG</div>
  </div>
}

export default function AddNew() {
  const [productType, setProductType] = useState('');

  const handleProductType = (e) => setProductType(e.target.value);

  return (
    <form id="product_form" onSubmit={handleSubmit} method="post">
      <h1>Product Add</h1>
      <button type="submit">Save</button>
      <a href="/">Cancel</a>
      <hr/>
      SKU <input id="sku" type="text" name="sku"/>
      Name <input id="name" type="text" name="name"/>
      Price ($) <input id="price" type="number" name="price"/>
      <select id="productType" name="productType" value={productType} onChange={handleProductType}>
        <option value="">Type Switcher</option>
        <option value="dvd">DVD</option>
        <option value="furniture">Furniture</option>
        <option value="book">Book</option>
      </select>
      {typeContent[productType]}
    </form>
  );
}
