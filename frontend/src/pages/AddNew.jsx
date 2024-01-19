import RestApiClient from "../services/RestApiClient";

function handleSubmit(e) {
  e.preventDefault();
  const formData = new FormData(e.target);
  RestApiClient.create(formData);
}

export default function AddNew() {
  return (
    <form onSubmit={handleSubmit} method="post">
      <input name="name"/>
      <button type="submit">Save</button>
    </form>
  );
}
