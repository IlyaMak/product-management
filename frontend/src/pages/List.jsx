import {useEffect, useState} from "react";
import RestApiClient from "../services/RestApiClient";

const typeContent = (product) => {
  const specificAttributes = {
    'dvd': <div>Size: {product.size} MB</div>,
    'book': <div>Weight: {product.weight}KG</div>,
    'furniture': <div>Dimension: {product.height}x{product.width}x{product.length}</div>
  };
  return specificAttributes[product.type];
}

export default function List() {
  const [products, setProducts] = useState([]);
  useEffect(() => {
    RestApiClient.index()
      .then((response) => response.json())
      .then((json) => setProducts(json));
  }, []);

  return (
    <>
      <h1>Product List</h1>
      <a href="/add-product">ADD</a>
      <button id="delete-product-btn">MASS DELETE</button>
      <hr/>
      {products.map((product, index) => (
        <div key={index}>
          <input type="checkbox" className="delete-checkbox"/>
          <div>{product.sku}</div>
          <div>{product.name}</div>
          <div>{product.price} $</div>
          <div>{typeContent(product)}</div>
        </div>
      ))}
    </>
  );
}
