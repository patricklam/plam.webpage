import org.junit.Test;
import static org.junit.Assert.*;

public class A6Q1 {
  @Test
  public void isEmpty() {
    List<Integer> t = new List<Integer>();
    t.append(4);
    assertFalse(t.isEmpty());
  }
}