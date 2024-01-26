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
  const [productIdsForDeletion, setProductIdsForDeletion] = useState([]);
  useEffect(() => {
    RestApiClient.index()
      .then((response) => response.json())
      .then((json) => setProducts(json));
  }, []);

  const handleChangeCheckbox = (e) => {
    const productId = e.target.value;

    if (e.target.checked) {
      setProductIdsForDeletion([...productIdsForDeletion, productId]);
      return;
    }

    setProductIdsForDeletion(
      productIdsForDeletion.filter((value) => value !== productId)
    );
  }

  const handleDeleteButton = () =>
    RestApiClient.delete(JSON.stringify(productIdsForDeletion));

  return (
    <>
      <h1>Product List</h1>
      <a href="/add-product">ADD</a>
      <button id="delete-product-btn" onClick={handleDeleteButton}>MASS DELETE</button>
      <hr/>
      {products.map((product, index) => (
        <div key={index}>
          <input type="checkbox" className="delete-checkbox" name="deleteCheckbox" value={parseInt(product.id)}
                 onChange={handleChangeCheckbox}/>
          <div>{product.sku}</div>
          <div>{product.name}</div>
          <div>{product.price} $</div>
          <div>{typeContent(product)}</div>
        </div>
      ))}
    </>
  );
}
