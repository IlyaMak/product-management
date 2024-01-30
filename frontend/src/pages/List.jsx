import {useEffect, useState} from 'react';
import RestApiClient from '../services/RestApiClient';
import './List.scss';
import Footer from '../components/Footer/Footer';

const emptyProductsErrorMessage = 'No Products';

const typeContent = (product) => {
  const specificAttributes = {
    'dvd': <div>Size: {product.size} MB</div>,
    'book': <div>Weight: {product.weight}KG</div>,
    'furniture': <div>Dimension: {product.height}x{product.width}x{product.length}</div>
  };
  return specificAttributes[product.type];
};

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
  };

  const handleDeleteButton = () =>
    RestApiClient.delete(JSON.stringify(productIdsForDeletion));

  return (
    <div className="main-container">
      <div className="header-container">
        <h1>Product List</h1>
        <div className="actions-container actions-container--list">
          <a className="button button--success" href="/add-product">
            ADD
          </a>
          <button id="delete-product-btn" className="button button--danger" onClick={handleDeleteButton}>
            MASS DELETE
          </button>
        </div>
      </div>
      <hr/>
      <div className="products-section">
        {
          products.length > 0
            ? products.map((product, index) => (
              <div key={index} className="product-card">
                <input type="checkbox" className="delete-checkbox" name="deleteCheckbox" value={parseInt(product.id)}
                       onChange={handleChangeCheckbox}/>
                <div className="product-card__content">
                  <div>{product.sku}</div>
                  <div>{product.name}</div>
                  <div>{product.price} $</div>
                  <div>{typeContent(product)}</div>
                </div>
              </div>
            ))
            : <h1 className="header-no-products">{emptyProductsErrorMessage}</h1>
        }
      </div>
      <Footer/>
    </div>
  );
}
